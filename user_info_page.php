<?php
require_once(dirname(__FILE__) . '\api\user_api.php');

isLogedIn();

global $user;
if (isset($_GET['id'])) {
    $user = getUserInfoById($_GET['id']);
    isEntry404(($user['id'] == -1));
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

<body onload="createUserLentBookTableItems(<?php echo $user['id']; ?>);">
    <div class="page">
        <?php include_once('html/header_navbar.php'); ?>
        <div class="page-content d-flex align-items-stretch">
            <?php include_once('html/side_navbar.php'); ?>
            <div class="content-inner">
                <!-- Page Header-->
                <header class="page-header">
                    <div class="container-fluid">
                        <h2 class="no-margin-bottom">用户管理</h2>
                    </div>
                </header>
                <!-- Breadcrumb-->
                <div class="breadcrumb-holder container-fluid">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">主页</a></li>
                        <li class="breadcrumb-item"><a href="user_manager.php">用户管理</a></li>
                        <li class="breadcrumb-item active">用户<?php echo $user['id']; ?></li>
                    </ul>
                </div>

                <section class="no-padding-bottom">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="client card">
                                    <div class="card-body text-center">
                                        <div class="client-avatar"><img src=<?php echo "{$user['avatar']}"; ?> alt="void" class="img-fluid rounded-circle">
                                            <div class="status <?php echo $user['online'] ? 'bg-green' : 'bg-red'; ?>"></div>
                                        </div>
                                        <div class="client-title">
                                            <h3><?php echo $user['name']; ?></h3>
                                            <span>id：<?php echo $user['id']; ?></span>
                                            <a href="javascript:void(0);">发送消息</a>
                                        </div>
                                        <div class="client-info">
                                            <div class="row">
                                                <div class="col-4"><strong><?php echo count($user['books']); ?></strong><br><small>借书/本</small></div>
                                                <!-- TODO: 暂时可不实现以下功能 -->
                                                <div class="col-4"><strong><?php echo count($user['books']); ?></strong><br><small>预约/本</small></div>
                                                <div class="col-4"><strong><?php echo count($user['books']); ?></strong><br><small>已还/本</small></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="statistic d-flex align-items-center no-padding">
                                    <div class="container-fluid no-padding">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="statistic d-flex align-items-center bg-white has-shadow">
                                                    <div class="icon bg-red"><i class="fa fa-user"></i></div>
                                                    <div>
                                                        <h3>账号</h3><?php echo $user['account']; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="statistic d-flex align-items-center bg-white has-shadow">
                                                    <div class="icon bg-green"><i class="fa fa-lock"></i></div>
                                                    <div>
                                                        <h3>密码</h3><?php echo $user['password']; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="statistic d-flex align-items-center bg-white has-shadow">
                                    <div class="icon bg-orange"><i class="fa fa-check-circle"></i></div>
                                    <div>
                                        <h3>MD5</h3><?php echo $user['md5']; ?>
                                    </div>
                                </div>
                                <div class="statistic d-flex align-items-center bg-white has-shadow">
                                    <div class="icon bg-orange"><i class="fa fa-image"></i></div>
                                    <div class="text-xsmall">
                                        <h3>头像地址</h3><?php echo "<a href='{$user['avatar']}' target='_blank'>{$user['avatar']}</a>"; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="container-fluid">
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
                                            <th class="text-center">转到</th>
                                        </tr>
                                    </thead>
                                    <tbody id="user_lent_books_table">
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
</body>

</html>
