<?php
require_once('api/book_api.php');
isLogedIn();

global $book;
if (isset($_GET['id'])) {
    $book = getBookInfoById($_GET['id']);
} else {
    isEntry404(true);
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>图书<?php echo $book['id']; ?></title>
    <?php include_once('html/included_head.php'); ?>
    <link rel="stylesheet" href="/vendor/bootstrap/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="css/style.custom.css">
</head>

<body onload="createUserLentItemsForBook(<?php echo $book['id']; ?>);">
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
                        <li class="breadcrumb-item"><a href="book_manager.php">图书管理</a></li>
                        <li class="breadcrumb-item active">图书<?php echo $book['id']; ?></li>
                    </ul>
                </div>

                <section class="forms no-padding-bottom">
                    <div class="container-fluid d-flex flex-row">
                        <div class="row flex-fill p-3">
                            <div class="card col-lg-4 no-padding">
                                <div class="card-header">
                                    <h3>书籍封面</h3>
                                </div>
                                <div class="card-body d-flex align-items-center">
                                    <img src=<?php echo "{$book['image']}"; ?> alt="void" class="img-fluid">
                                </div>
                            </div>
                            <div class="card col-lg-8 no-padding">
                                <div class="card-header">
                                    <h3>基本信息</h3>
                                </div>
                                <div class="card-body d-flex">
                                    <div class="flex-fill container-fuild">

                                        <div class="form-group row">
                                            <label class="col-lg-3 form-control-label">ID</label>
                                            <div class="col-lg-9">
                                                <input type="text" disabled="" placeholder=<?php echo "'{$book['id']}'"; ?> class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 form-control-label">ISBN13</label>
                                            <div class="col-lg-9">
                                                <input type="text" disabled="" placeholder=<?php echo "'{$book['isbn13']}'"; ?> class="form-control">
                                            </div>
                                        </div>
                                        <div class="line"></div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 form-control-label">书名</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control" value=<?php echo "'{$book['title']}'"; ?>>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 form-control-label">副标题</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control" value=<?php echo "'{$book['subtitle']}'"; ?>>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 form-control-label">原标题</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control" value=<?php echo "'{$book['origin_title']}'"; ?>>
                                            </div>
                                        </div>
                                        <div class="line"></div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label">作者</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value=<?php echo "'{$book['author']}'"; ?>>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Forms Section-->
                <section class="forms no-padding">
                    <div class="container-fluid">
                        <div class="row">

                            <!-- Modal Form-->
                            <!-- <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-header d-flex align-items-center">
                                        <h3 class="h4">Modal Form</h3>
                                    </div>
                                    <div class="card-body text-center">
                                        <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-primary">Form in simple modal </button>
                                        <div id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                                            <div role="document" class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 id="exampleModalLabel" class="modal-title">Signin Modal</h4>
                                                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Lorem ipsum dolor sit amet consectetur.</p>
                                                        <form>
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <input type="email" placeholder="Email Address" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Password</label>
                                                                <input type="password" placeholder="Password" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="submit" value="Signin" class="btn btn-primary">
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
                                                        <button type="button" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <!-- Form Elements -->
                            <div class="col-lg-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>详细信息</h3>
                                    </div>
                                    <div class="card-body">
                                        <form class="form-horizontal">

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">摘要</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" rows="6"><?php echo $book['summary']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="line"></div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">作者简介</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" rows="6"><?php echo $book['author_intro']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="line"></div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">翻译</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" value=<?php echo "'{$book['translator']}'"; ?>>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">出版社</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" value=<?php echo "'{$book['publisher']}'"; ?>>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">出版时间</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" id="datetimepicker" type="text" value=<?php echo "'{$book['pubdate']}'"; ?>>
                                                </div>
                                            </div>
                                            <div class="line"></div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">页数</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" value=<?php echo "'{$book['pages']}'"; ?> onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">评分</label>
                                                <div class="col-sm-9">
                                                    <input type="text" disabled="" placeholder=<?php echo "'{$book['rating']}'"; ?> class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">装帧形式</label>
                                                <div class="col-sm-9">
                                                    <select name="account" class="form-control mb-3">
                                                        <option><?php echo $book['binding']; ?></option>
                                                        <option>平装</option>
                                                        <option>精装</option>
                                                        <option>线装</option>
                                                        <option>单行本</option>
                                                        <option>合订本</option>
                                                        <option>普及本</option>
                                                        <option>缩印本</option>
                                                        <option>袖珍本</option>
                                                        <option>特藏本</option>
                                                        <option>豪华本</option>
                                                        <option>简册装</option>
                                                        <option>卷轴装</option>
                                                        <option>经折装</option>
                                                        <option>旋风装</option>
                                                        <option>蝴蝶装</option>
                                                        <option>包背装</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">标签<a href="#" target="_blank"><i class="p-2 fa fa-plus"></i></a></label>
                                                <div class="col-sm-9">
                                                    <div class="bootstrap-label">
                                                        <?php
                                                        $tags = explode(',', $book['tags']);
                                                        foreach ($tags as $tag) {
                                                            echo "<span class='label label-secondary m-1'>$tag</span>";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="line"></div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">目录章节</label>
                                                <div class="col-sm-9">
                                                    <?php
                                                    $nl_count = substr_count($book['catalog'], "\n") * 26;
                                                    $nl_count = $nl_count < 200 ? 200 : ($nl_count > 1000 ? 1000 : $nl_count);
                                                    echo '<textarea style="height:' . $nl_count . 'px;" class="form-control" rows="6">';
                                                    echo $book['catalog'];
                                                    echo '</textarea>';
                                                    ?>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4">正借此书的用户</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">用户id</th>
                                            <th class="text-center">用户名</th>
                                            <th class="text-center">借书时间</th>
                                            <th class="text-center">转到</th>
                                        </tr>
                                    </thead>
                                    <tbody id="users-lent-the-book-table">
                                    </tbody>
                                </table>
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
        <script src="vendor/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap-datetimepicker.zh-CN.js"></script>
        <script src="js/charts-custom.js"></script>
        <!-- Main File-->
        <script src="js/front.js"></script>
        <!-- Ajax Request File -->
        <script src="js/ajax/user_lent_books.js"></script>
        <!-- DataTimePicker Plugin -->
        <script>
            var today = new Date();
            $('#datetimepicker').datetimepicker({
                language: 'zh-CN',
                format: 'yyyy-mm-dd',
                autoclose: true,
                endDate: today,
                startView: 3,
                minView: 2,
                todayBtn: true,
                todayHighlight: true,
            });
        </script>
</body>

</html>
