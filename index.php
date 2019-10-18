<?php
require_once('api/MySqlAPI.php');

$db = MySqlAPI::getInstance();
$user_online = $db->getRow("select SUM(u_online) from userprivate")['SUM(u_online)'];
$users_num = $db->getRow("select COUNT(*) from userinfo")['COUNT(*)'];
$db->useDataBase('bookdb');
$rm_num = $db->getRow("select SUM(remaining) from bookinfo")['SUM(remaining)'];
$lent_num = $db->getRow("select SUM(lent) from bookdetail")['SUM(lent)'];
$db->close();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home</title>
    <?php include_once('html/included_head.php'); ?>
</head>

<body>
    <div class="page">
        <?php include_once('html/header_navbar.php'); ?>
        <div class="page-content d-flex align-items-stretch">
            <?php include_once('html/side_navbar.php'); ?>
            <div class="content-inner">
                <!-- Page Header-->
                <header class="page-header">
                    <div class="container-fluid">
                        <h2 class="no-margin-bottom">主页</h2>
                    </div>
                </header>
                <!-- Dashboard Counts Section-->
                <section class="dashboard-counts no-padding-bottom">
                    <div class="container-fluid">
                        <div class="row bg-white has-shadow">
                            <!-- Item -->
                            <div class="col-xl-4 col-sm-6">
                                <div class="item d-flex align-items-center">
                                    <div class="icon bg-violet"><i class="fa fa-user"></i></div>
                                    <div class="title"><span>用户<br>在线人数</span>
                                        <div class="progress">
                                            <div role="progressbar" style=<?php $res = $user_online / $users_num * 100;
                                                                            echo "\"width: $res%; height: 4px;\""; ?> class="progress-bar bg-violet"></div>
                                        </div>
                                    </div>
                                    <div class="number"><strong><?php echo $user_online; ?></strong></div>
                                </div>
                            </div>
                            <!-- Item -->
                            <div class="col-xl-4 col-sm-6">
                                <div class="item d-flex align-items-center">
                                    <div class="icon bg-green"><i class="fa fa-book"></i></div>
                                    <div class="title"><span>图书<br>馆藏数量</span>
                                        <div class="progress">
                                            <div role="progressbar" style=<?php $res = $rm_num / ($rm_num + $lent_num) * 100;
                                                                            echo "\"width: $res%; height: 4px;\""; ?> class="progress-bar bg-green"></div>
                                        </div>
                                    </div>
                                    <div class="number"><strong><?php echo $rm_num; ?></strong></div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="item d-flex align-items-center">
                                    <div class="icon bg-red"><i class="fa fa-address-book"></i></div>
                                    <div class="title"><span>图书<br>已被借出</span>
                                        <div class="progress">
                                            <div role="progressbar" style=<?php $res = $lent_num / ($rm_num + $lent_num) * 100;
                                                                            echo "\"width: $res%; height: 4px;\""; ?> class="progress-bar bg-red"></div>
                                        </div>
                                    </div>
                                    <div class="number"><strong><?php echo $lent_num; ?></strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
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
    <script src="js/charts-home.js"></script>
    <!-- Main File-->
    <script src="js/front.js"></script>
</body>

</html>
