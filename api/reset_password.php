<?php
require_once(dirname(__FILE__) . '\mysql_api.php');
require_once(dirname(__FILE__) . '\utility.php');

refreshCheck();

$submit = @$_POST['submit'] ? $_POST['submit'] : null;
if ($submit && $submit === 'reset_password') {
    $verify_info = [];

    if (isset($_POST['submit']) && $_POST['submit'] === 'reset_password') {
        if (isset($_SESSION['verify_code'])) {
            $verify_info['email'] = explode(',', $_SESSION['verify_code'])[0];
            $verify_info['code'] = explode(',', $_SESSION['verify_code'])[1];
            $verify_info['time'] = explode(',', $_SESSION['verify_code'])[2];

            if ($verify_info['code'] != $_POST['verify_code']) {
                echo '<script>alert("验证码不正确！");history.go(-1);</script>';
                die;
            }

            if (strlen($_POST['password']) < 6 || strlen($_POST['password']) > 16) {
                echo '<script>alert("密码长度必须为6-16个字符！"); history.go(-1); </script>';
                die;
            }

            // 默认超时时间为5分钟
            if (time() - $verify_info['time'] > 18000) {
                unset($_SESSION['verify_code']);
                echo '<script>alert("请求超时，请重新获取验证码！");history.go(-1);</script>';
                die;
            }

            $db = MySqlAPI::getInstance();

            $res = $db->update('userprivate', ['password' => $_POST['password']], "account='{$verify_info['email']}'");
            if ($res == 0) {
                $db->close();
                echo '<script>alert("重置密码出错，请检查邮箱是否为注册时填写的邮箱！");history.go(-1);</script>';
                die;
            }
            $db->close();

            unset($_SESSION['verify_code']);
            echo '<script>alert("重置密码成功！");location.href = "http://bookstudy.com/login_page.php"</script>';
        } else {
            echo '<script>alert("验证码不正确！");history.go(-1);</script>';
        }
    }
}

echo '<script>history.go(-1);</script>';
