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
    <title>用户管理</title>
    <?php include_once('html/included_head.php'); ?>
</head>

<body onload="createUserTableItems(<?php echo $page; ?>);">
    <div class=" page">
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
                        <li class="breadcrumb-item active">用户管理</li>
                    </ul>
                </div>

                <section class="dashboard-header">
                    <div class="container-fluid">
                        <!-- TODO:图书分类的数据使用php页面动态生成 -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="statistic d-flex align-items-center bg-white has-shadow">
                                    <div class="icon bg-red"><i class="fa fa-tasks"></i></div>
                                    <div class="text"><strong>分类1</strong><br><small>10本</small></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="statistic d-flex align-items-center bg-white has-shadow">
                                    <div class="icon bg-green"><i class="fa fa-tasks"></i></div>
                                    <div class="text"><strong>分类2</strong><br><small>12本</small></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <ul id="user-pagination1" class="pagination">
                        </ul>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4">所有用户</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">排序</th>
                                            <th class="text-center">用户id</th>
                                            <th class="text-center">用户名（昵称）</th>
                                            <th class="text-center">账号</th>
                                            <th class="text-center">密码</th>
                                            <th class="text-center">是否在线</th>
                                            <th class="text-center">其他操作</th>
                                        </tr>
                                    </thead>
                                    <tbody id="user-items-body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <ul id="user-pagination2" class="pagination">
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
    <script src="js/charts-custom.js"></script>
    <!-- Main File-->
    <script src="js/front.js"></script>
    <!-- Ajax File -->
    <script src="js/ajax/pagination.js"></script>
</body>

</html>
