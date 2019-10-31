<?php
require_once(dirname(__FILE__) . '\utility.php');

refreshCheck();

/** 1.首先验证验证码是否正确 */
if (isset($_SESSION['verify_code'])) {
    // 0=>email, 1=>code, 2=>time
    $verify_info = explode(',', $_SESSION['verify_code']);
    if (!isset($_POST['verify_code']) || $verify_info[1] != $_POST['verify_code']) {
        echo '<script>alert("验证码不正确！");history.go(-1);</script>';
        die;
    }

    // 默认超时时间为5分钟
    if (time() - $verify_info[2] > 300) {
        unset($_SESSION['verify_code']);
        echo '<script>alert("请求超时，请重新获取验证码！");history.go(-1);</script>';
        die;
    }

    unset($_SESSION['verify_code']);
} else {
    echo '<script>alert("请重新获取验证码！");history.go(-1);</script>';
    // isEntry404(true);
    die;
}

/** 2.根据不同的请求进行不同的操作 */

$submit = @$_POST['submit'];
if ($submit) {
    $password = @$_POST['password'];
    if ($submit === 'reset_password') {
        if (!$password || strlen($password) < 6 || strlen($password) > 16) {
            echo '<script>alert("新密码长度必须为6-16个字符！"); history.go(-1); </script>';
            die;
        }

        $db = MySqlAPI::getInstance();

        // 如果存在该邮箱账号，则进行修改密码
        if ($db->getRow("select id from admininfo where email='{$verify_info[0]}'")) {
            $db->update('admininfo', ['password' => $password], "email='{$verify_info[0]}'");
        } else {
            $db->close();
            echo '<script>alert("重置密码出错，请检查邮箱是否为注册时填写的邮箱！");</script>';
            die;
        }

        $db->close();
        unset($_SESSION['verify_code']);
        echo '<script>alert("重置密码成功！");location.href = "http://bookstudy.com/login_page.php"</script>';
    } else if ($submit === 'register_account') {
        if (!$password || strlen($password) < 6 || strlen($password) > 16) {
            echo '<script>alert("密码长度必须为6-16个字符！"); history.go(-1); </script>';
            die;
        }
        $adminname = @$_POST['adminname'];
        if (!isValidString($adminname) || strlen($adminname) > 16) {
            echo '<script>alert("管理员名称不合法，请重新输入！"); history.go(-1); </script>';
            die;
        }
        $email = @$_POST['email'];
        if (!$email) {
            echo '<script>alert("邮箱地址不能为空！"); history.go(-1); </script>';
            die;
        }

        $db = MySqlAPI::getInstance();

        // 如果邮箱存在，则不允许重复注册
        if ($db->getRow("select id from admininfo where email='$verify_info[0]'")) {
            $db->close();
            echo '<script>alert("邮箱已经存在，请使用其它邮箱再次注册！"); history.go(-1); </script>';
            die;
        }

        $db->insert('admininfo', ['email' => $email, 'name' => $adminname, 'password' => $password]);

        $db->close();
        unset($_SESSION['verify_code']);
        echo '<script>alert("注册成功！点击确认进入登陆页面");location.href = "http://bookstudy.com/login_page.php"</script>';
        // todo：暂时不加审核功能
        // echo '<script>alert("注册成功！系统管理员审核中...\n一般审核时间为1-2天，请您耐心等待。");location.href = "http://bookstudy.com/login_page.php"</script>';
    }
}
