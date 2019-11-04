<?php
require_once(dirname(__FILE__) . '\api\utility.php');
refreshOnce();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>找回密码</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <link rel="stylesheet" href="css/style.custom.css">

</head>

<body class="page">
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-10 offset-1 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 col-xl-6 offset-xl-3">
                    <div class="logo-brand">
                        <img src="img/appicon/BookStudy.png" alt="logo" width="180">
                    </div>

                    <div class="card card-primary">
                        <div class="card-header d-flex justify-content-between">
                            <h3>输入邮箱</h3>
                            <small class="help-text">目前仅支持QQ邮箱找回密码</small>
                        </div>

                        <div class="card-body pl-5 pr-5 pt-4 pb-4">
                            <form method="post" action="api/forget_pwd_validate.php?obj=admin">
                                <div class="row justify-content-between">
                                    <div class="col-lg-8">
                                        <div class="form-group-material">
                                            <input id="input-email" type="email" name="account" required class="input-material">
                                            <label for="input-email" class="label-material">邮件地址</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 text-right">
                                        <button onclick="sendVerifyCodeMail($('#input-email'));" type="button" class="btn btn-primary">
                                            获取验证码
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <div class="form-group-material">
                                        <input id="input-password" minlength="6" maxlength="16" type="password" name="password" required autocomplete="off" class="input-material">
                                        <label for="input-password" class="label-material">新密码</label>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="form-group-material">
                                        <input id="input-code" type="text" name="verify_code" required autocomplete="off" class="input-material">
                                        <label for="input-code" class="label-material">验证码</label>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button name="submit" value="forget_password" type="submit" class="btn btn-primary btn-lg btn-block">
                                        确认提交
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <footer class="footer text-center">&copy; 2019 Book Study.</footer> -->
    </section>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="js/front.js"></script>
    <script src="js/utility.js"></script>
</body>

</html>
