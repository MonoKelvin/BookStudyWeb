<?php
session_start();
$_SESSION['id'] = 1; // 這裡填入用戶id
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>管理员登录</title>
    <?php include_once('html/included_head.php'); ?>
</head>

<body>
    <div class="page login-page">
        <div class="container d-flex align-items-center">
            <div class="form-holder has-shadow">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="info d-flex align-items-center">
                            <div class="content text-right">
                                <div class="logo">
                                    <h1>BookStudy书 斋</h1>
                                </div>
                                <p>直当花院里，书斋望晓开。</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 bg-white">
                        <div class="form d-flex align-items-center">
                            <div class="content">
                                <form method="post" class="form-validate">
                                    <div class="form-group">
                                        <input id="login-username" type="text" name="loginUsername" required data-msg="账号" class="input-material">
                                        <label for="login-username" class="label-material">账号</label>
                                    </div>
                                    <div class="form-group">
                                        <input id="login-password" type="password" name="loginPassword" required data-msg="密码" class="input-material">
                                        <label for="login-password" class="label-material">密码</label>
                                    </div><a id="login" href="index.php" class="btn btn-primary">登录</a>
                                    <!-- This should be submit button but I replaced it with <a> for demo purposes-->
                                </form><a href="#" class="forgot-pass">忘记密码?</a><br><small>没有账号? </small><a href="register.php" class="signup">点击注册</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyrights text-center">
            <p>Developed by <a href="https://github.com/MonoKelvin">MonoKelvin</a>
                <!-- Please do not remove the back-link to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :) -->
                <br /> Thanks for the page designed by <a href="https://bootstrapious.com/donate" class="external">Bootstrapious</a>
            </p>
        </div>
    </div>
    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <!-- Main File-->
    <script src="js/front.js"></script>
</body>

</html>
