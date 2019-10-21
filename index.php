<?PHP
require_once('api/utility.php');
isLogedIn();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>主页</title>
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

                <section class="dashboard-counts no-padding-bottom">
                    <div class="container-fluid">
                        <div class="row bg-white has-shadow">
                            <!-- Item -->
                            <div class="col-xl-4 col-sm-6">
                                <div class="item d-flex align-items-center">
                                    <div class="icon bg-violet"><i class="fa fa-user"></i></div>
                                    <div class="title"><span>用户<br>在线人数</span>
                                        <div class="progress">
                                            <div id="online_progress" role="progressbar" style="height: 4px;" class="progress-bar bg-violet"></div>
                                        </div>
                                    </div>
                                    <div class="number">
                                        <strong id="online_number"></strong>
                                    </div>
                                </div>
                            </div>
                            <!-- Item -->
                            <div class="col-xl-4 col-sm-6">
                                <div class="item d-flex align-items-center">
                                    <div class="icon bg-green"><i class="fa fa-book"></i></div>
                                    <div class="title"><span>图书<br>馆藏数量</span>
                                        <div class="progress">
                                            <div id="remaining_progress" role="progressbar" style="height: 4px;" class="progress-bar bg-green"></div>
                                        </div>
                                    </div>
                                    <div class="number">
                                        <strong id="remaining_number"></strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="item d-flex align-items-center">
                                    <div class="icon bg-red"><i class="fa fa-address-book"></i></div>
                                    <div class="title"><span>图书<br>已被借出</span>
                                        <div class="progress">
                                            <div id="lent_progress" role="progressbar" style="height: 4px;" class="progress-bar bg-green"></div>
                                        </div>
                                    </div>
                                    <div class="number">
                                        <strong id="lent_number"></strong>
                                    </div>
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
    <!-- <script src="vendor/popper.js/umd/popper.min.js"> </script> -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="js/charts-home.js"></script>
    <!-- Main File-->
    <script src="js/front.js"></script>
    <!-- Ajax Request File -->
    <script src="js/ajax/statistics.js"></script>
</body>

</html>
