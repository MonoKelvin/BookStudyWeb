<?php
require_once(dirname(__FILE__) . '\utility.php');

refreshCheck();

// 1.获取是要验证谁的验证码
$obj = @$_GET['obj'];

// 2.获取请求的信息
$account = @$_POST['account'];
$password = @$_POST['password'];
$verify_code = @$_POST['verify_code'];
$register_id = @$_POST['register_id'];

// 3.判断是否为主动提交
if (@$_POST['submit'] == 'submit') {

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
        echo '<script>alert("无法为空用户进行注册!"); history.go(-1); </script>';
        die;
    }

    // 检查在 register_queue（注册等待队列）中的id和请求的id是否一致
    $res = $db->getRow('select * from register_queue where id=' . $register_id);
    if (!$res) {
        $db->close();
        echo '<script>alert("注册信息过时，请重新注册！"); history.go(-1); </script>';
        die;
    }

    // 取出数据后就可以删除了
    $db->deleteOne('register_queue', 'id=' . $register_id);

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

    $name = @$_POST['name'];
    if (!isValidString($name) || strlen($name) > 16) {
        echo '<script>alert("管理员名称不合法，请重新输入！"); history.go(-1); </script>';
        die;
    }
    if (!$account) {
        echo '<script>alert("邮箱地址不能为空！"); history.go(-1); </script>';
        die;
    }

    // 这里还需要判断是否重复注册，因为其他用户注册后数据库中可能会新增记录
    $res = $db->getRow("select id from admininfo where account='$verify_info[0]'");
    if (@$res['id']) {
        $db->close();
        echo '<script>alert("账号已经存在，请重新注册！");history.go(-1)"</script>';
        die;
    }

    $db->insert('admininfo', ['account' => $account, 'name' => $name, 'password' => $password]);
    $db->close();

    echo '<script>alert("注册成功！点击确认进入登陆页面");location.href = "http://bookstudy.com/login_page.php"</script>';

    // todo：暂时不加审核功能
    // echo '<script>alert("注册成功！系统管理员审核中...\n一般审核时间为1-2天，请您耐心等待。");location.href = "http://bookstudy.com/login_page.php"</script>';
}

isEntry404();
