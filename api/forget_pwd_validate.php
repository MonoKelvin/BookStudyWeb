<?php
require_once(dirname(__FILE__) . '\utility.php');

refreshCheck();

// 1.获取是要验证谁的验证码
$obj = @$_GET['obj'];

// 2.获取请求的账号(邮箱)、密码和验证码
$account = @$_POST['account'];
$password = @$_POST['password'];
$verify_code = @$_POST['verify_code'];

// 3.判断是否为主动提交
if (@$_POST['submit']) {

    $db = MySqlAPI::getInstance();

    $table = null;
    // 选择要修改的表
    if ($obj === 'admin') {
        $table = 'admininfo';
    } else if ($obj === 'user') {
        $table = 'userprivate';
    }

    // 检查验证对象是否为空
    if ($table === null) {
        $db->close();
        echo '<script>alert("无法为空用户进行验证!"); history.go(-1); </script>';
        die;
    }

    // 检查在缓冲消息中的账号和请求的账号是否一致
    $res = $db->getRow("select id,verify_msg from $table where account='$account'");
    if (!$res) {
        $db->close();
        echo '<script>alert("邮箱不匹配，请检查邮箱是否为注册时填写的邮箱！"); history.go(-1); </script>';
        die;
    }

    // 拆分数据：0=>account, 1=>code, 2=>time
    $verify_info = explode(',', $res['verify_msg']);

    // 如果有输入验证码
    if (is_array($verify_code) && count($verify_code) > 2) {
        // 如果不一致的就报错
        if ($verify_info[1] != $verify_code) {
            $db->close();
            echo '<script>alert("验证码不正确！"); history.go(-1); </script>';
            die;
        }

        // 默认超时时间为5分钟
        if (time() - $verify_info[2] > 300) {
            $db->close();
            echo '<script>alert("验证码失效，请重新获取！"); history.go(-1); </script>';
            die;
        }
    } else {
        $db->close();
        echo '<script>alert("请重新获取验证码！"); history.go(-1); </script>';
        die;
    }

    // 密码必须符合要求
    if ($password == null || strlen($password) < 6 || strlen($password) > 16) {
        $db->close();
        echo '<script>alert("新密码长度必须为6-16个字符！"); history.go(-1); </script>';
        die;
    }

    // 4.根据不同的提交信息进行不同的操作
    if ($obj && $account) {
        $db->update($table, ['password' => $password, 'verify_msg' => null], "account='$verify_info[0]'", 'id=' . $res['id']);
        $db->close();

        // 如果是管理员就跳到登录界面
        if ($obj === 'admin') {
            echo '<script>alert("重置密码成功！");location.href = "http://bookstudy.com/login_page.php"</script>';
        } else {
            echo '<script>alert("重置密码成功！");</script>';
        }

        // 成功退出
        exit(0);
    }
}

isEntry404();
