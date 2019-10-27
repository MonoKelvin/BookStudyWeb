<?PHP
require_once('api/utility.php');
isLogedIn();

global $page;
if (isset($_GET['page'])) {
    if ($_GET['page'] > 0) {
        $page = $_GET['page'];
    } else {
        isEntry404(true);
    }
} else {
    $page = 1;
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>图书管理</title>
    <?php include_once('html/included_head.php'); ?>
</head>

<body onload="createBookTableItems(<?php echo $page; ?>);">
    <div class="page">
        <?php include_once('html/header_navbar.php'); ?>
        <div class="page-content d-flex align-items-stretch">
            <?php include_once('html/side_navbar.php'); ?>
            <div class="content-inner">
                <!-- Page Header-->
                <header class="page-header">
                    <div class="container-fluid">
                        <h2 class="no-margin-bottom">图书管理</h2>
                    </div>
                </header>
                <!-- Breadcrumb-->
                <div class="breadcrumb-holder container-fluid">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">主页</a></li>
                        <li class="breadcrumb-item active">图书管理</li>
                    </ul>
                </div>

                <section class="dashboard-header">
                    <div class="container-fluid">
                        <!-- TODO:图书分类的数据使用php页面动态生成 -->
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="statistic d-flex align-items-center bg-white has-shadow">
                                    <div class="icon bg-red"><i class="fa fa-tasks"></i></div>
                                    <div class="text"><strong>分类1</strong><br><small>10本</small></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="statistic d-flex align-items-center bg-white has-shadow">
                                    <div class="icon bg-green"><i class="fa fa-tasks"></i></div>
                                    <div class="text"><strong>分类2</strong><br><small>12本</small></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="statistic d-flex align-items-center bg-white has-shadow">
                                    <div class="icon bg-blue"><i class="fa fa-tasks"></i></div>
                                    <div class="text"><strong>分类3</strong><br><small>12本</small></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="statistic d-flex align-items-center bg-white has-shadow">
                                    <div class="icon bg-orange"><i class="fa fa-tasks"></i></div>
                                    <div class="text"><strong>分类4</strong><br><small>12本</small></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <ul id="book-pagination1" class="pagination">
                        </ul>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4">所有图书</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">排序</th>
                                            <th class="text-center">id</th>
                                            <th class="text-center">书名</th>
                                            <th class="text-center">馆藏数量</th>
                                            <th class="text-center">已借出</th>
                                            <th class="text-center">其他操作</th>
                                        </tr>
                                    </thead>
                                    <tbody id="book-items-body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <ul id="book-pagination2" class="pagination">
                        </ul>
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
    <script src="vendor/bootstrap/js/bootstrap-paginator.js"></script>
    <!-- Main File-->
    <script src="js/front.js"></script>
    <!-- Ajax File -->
    <script src="js/ajax/book_pagination.js"></script>
</body>

</html>
