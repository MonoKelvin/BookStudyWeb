<?php
require_once(dirname(__FILE__) . '\api\user_api.php');
isLogedIn();
refreshOnce();

global $user;
if (isset($_GET['id'])) {
    $user = getUserInfoById($_GET['id']);
} else {
    isEntry404(true);
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>用户<?php echo $user['id']; ?></title>
    <?php include_once('html/included_head.php'); ?>
</head>

<body onload="createUserLentBookItems(<?php echo $user['id']; ?>);">
    <div class="page">
        <?php include_once('html/header_navbar.php'); ?>
        <div class="page-content d-flex align-items-stretch">
            <?php include_once('html/side_navbar.php'); ?>
            <div class="content-inner">
                <header class="page-header">
                    <div class="container-fluid">
                        <h2 class="no-margin-bottom">用户管理</h2>
                    </div>
                </header>
                <div class="breadcrumb-holder container-fluid">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">主页</a></li>
                        <li class="breadcrumb-item"><a href="user_manager.php">用户管理</a></li>
                        <li class="breadcrumb-item active">用户<?php echo $user['id']; ?></li>
                    </ul>
                </div>

                <section class="no-padding-bottom">
                    <form action="api/user_update.php" class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="container-fluid d-flex flex-row">
                            <div class="card col-lg-12 no-padding">
                                <div class="card-body d-flex align-items-center row">

                                    <div class="col-lg-4 d-flex justify-content-center flex-column">
                                        <div class="client card pb-4 pt-4">
                                            <div class="card-body text-center">
                                                <div class="client-avatar">
                                                    <img id="user-avatar" src="<?php echo $user['avatar']; ?>" alt="void" class="user-avatar">
                                                    <div class="status <?php echo $user['online'] ? 'bg-green' : 'bg-red'; ?>"></div>
                                                </div>
                                                <div class="client-title">
                                                    <h3><?php echo $user['name']; ?></h3>
                                                    <!-- <a href="javascript:void(0);">发送消息</a> -->
                                                </div>
                                                <div class="client-info">
                                                    <div class="row">
                                                        <div class="col-lg-12"><strong><?php echo count($user['books']); ?></strong><br><small>借书/本</small></div>
                                                        <!-- TODO: 暂时可不实现以下功能 -->
                                                        <!-- <div class="col-4"><strong>0</strong><br><small>预约/本</small></div> -->
                                                        <!-- <div class="col-4"><strong>0</strong><br><small>已还/本</small></div> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input id="tmp-file-input" name="image" onchange="changeUserAvatar(this)" type="file" class="hidden-form-control">
                                        <button type="button" class="btn btn-primary mt-2" onclick="$('#tmp-file-input').click();">更换头像</button>
                                        <small class="help-text mt-2">请选择不大于1M的png、jpg或jpeg格式的图片文件</small>
                                    </div>

                                    <div class="col-lg-8 pt-4">
                                        <div class="container-fluid">
                                            <div class="form-group row align-items-center">
                                                <label class="col-lg-3 form-control-label">用户ID</label>
                                                <div class="col-lg-9">
                                                    <input name="id" type="text" class="form-control" readonly value=<?php echo "'{$user['id']}'"; ?>>
                                                    <small class="help-text">用户ID号不可更改</small>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-lg-3 form-control-label">用户名（昵称）<span class="required-label-star">*</span></label>
                                                <div class="col-lg-9">
                                                    <input name="name" type="text" class="form-control" maxlength="16" autocomplete="off" value=<?php echo "'{$user['name']}'"; ?>>
                                                    <small class="help-text">用户名最长为16个字符</small>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-lg-3 form-control-label">账号<span class="required-label-star">*</span></label>
                                                <div class="col-lg-9">
                                                    <input name="account" type="text" class="form-control" maxlength="32" autocomplete="off" value=<?php echo "'{$user['account']}'"; ?>>
                                                    <small class="help-text">账号最长为32个字符</small>
                                                </div>
                                            </div>
                                            <div class="line"></div>

                                            <div class="form-group row align-items-center">
                                                <label class="col-lg-3 form-control-label">密码<strong class="required-label-star">*</strong></label>
                                                <div class="col-lg-9">
                                                    <input name="password" type="text" class="form-control" maxlength="16" autocomplete="off" value=<?php echo "'{$user['password']}'"; ?>>
                                                    <small class="help-text">密码长度范围为6-16个字符</small>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-lg-3 form-control-label">MD5</label>
                                                <div class="col-lg-9"><?php echo $user['md5']; ?></div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-lg-3 form-control-label">头像地址</label>
                                                <div class="col-lg-9 text-wrap ">
                                                    <a class="btn btn-warning" href=<?php echo "'{$user['avatar']}'" ?> target='_blank'>查看图片</a>
                                                </div>
                                            </div>
                                            <div class="line"></div>

                                            <!-- 表单按钮 -->
                                            <div class="form-group row justify-content-end">
                                                <div class="col-lg-2 pb-2">
                                                    <button type="button" data-toggle="modal" data-target="#alterUserAlert" class="form-control btn btn-primary">保存修改</button>
                                                    <div id="alterUserAlert" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
                                                        <div role="document" class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h3 class="modal-title">数据改动提示</h3>
                                                                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>你确定要保存当前用户数据的修改吗？</p>
                                                                    <p class="text-red">注意：更改任何一项都会导致用户无法正常登录，请谨慎操作！</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" data-dismiss="modal" class="btn btn-secondary">取消</button>
                                                                    <button id="alter-user-submit" type="submit" name="submit" value="submit" class="btn btn-primary">确定</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 pb-2">
                                                    <button type="button" onclick="window.location.reload();" class="form-control btn btn-secondary">还原</button>
                                                </div>
                                            </div>

                                            <small class="help-text float-right">
                                                注意：更改任何一项都会导致用户无法正常登录，请谨慎操作！
                                            </small>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>

                <div class="container-fluid pt-3">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4">借书列表</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">id</th>
                                            <th class="text-center">书名</th>
                                            <th class="text-center">作者</th>
                                            <th class="text-center">借书时间</th>
                                            <th class="text-center">应还时间</th>
                                            <th class="text-center">转到 / 还书</th>
                                        </tr>
                                    </thead>
                                    <tbody id="user-lent-books-table">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="js/charts-custom.js"></script>
    <!-- Main File-->
    <script src="js/front.js"></script>
    <!-- Ajax Request File -->
    <script src="js/ajax/user_lent_books.js"></script>
    <script>
        function changeUserAvatar(obj) {
            var file = obj.files && obj.files.length > 0 ? obj.files[0] : null;

            if (!file) {
                return;
            }
            if (file.size >= 1 * 1024 * 1024) {
                alert('文件不允许大于1M');
                return;
            }
            if (file.type !== 'image/png' && file.type !== 'image/jpg' && file.type !== 'image/jpeg') {
                alert('文件格式必须为：png/jpg/jpeg');
                return;
            }

            var reader = new FileReader();
            reader.onload = function(e) {
                var data = e.target.result;
                $('#user-avatar').attr('src', data);
            };
            reader.readAsDataURL(file);
            return;
        }
    </script>
</body>

</html>
