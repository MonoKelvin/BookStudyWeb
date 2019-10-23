<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>管理员注册</title>
    <?php include_once('html/included_head.php'); ?>
</head>

<body>
    <div class="page login-page">
        <div class="container d-flex align-items-center p-5">
            <div class="form-holder has-shadow">
                <div class="row">
                    <!-- Logo & Information Panel-->
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
                    <!-- Form Panel    -->
                    <div class="col-lg-6 bg-white">
                        <div class="form d-flex align-items-center">
                            <div class="content">
                                <form method="post" class="form-validate">
                                    <div class="form-group">
                                        <input id="register-username" type="text" name="registerUsername" required data-msg="Please enter your username" class="input-material">
                                        <label for="register-username" class="label-material">管理员名称</label>
                                    </div>
                                    <div class="form-group">
                                        <input id="register-email" type="email" name="registerEmail" required data-msg="Please enter a valid email address" class="input-material">
                                        <label for="register-email" class="label-material">邮件/电话</label>
                                    </div>
                                    <div class="form-group">
                                        <input id="register-password" type="password" name="registerPassword" required data-msg="Please enter your password" class="input-material">
                                        <label for="register-password" class="label-material">密码</label>
                                    </div>
                                    <div class="form-group terms-conditions">
                                        <input id="register-agree" name="registerAgree" type="checkbox" required value="1" data-msg="Your agreement is required" class="checkbox-template">
                                        <label for="register-agree">同意遵守《书斋管理员规章制度》</label>
                                    </div>
                                    <div class="form-group">
                                        <button id="regidter" type="submit" name="registerSubmit" class="btn btn-primary">注册</button>
                                    </div>
                                </form>
                                <small>已有账号? </small>
                                <a href="login_page.php" class="signup">点击登录</a>
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
