<?php
require_once(dirname(__FILE__) . '\utility.php');

refreshCheck();

// 1.获取是要验证谁的验证码
$obj = @$_GET['obj'];

// 2.获取请求的账号(邮箱)、密码和验证码，不管是注册还是更换密码都需要这3项
$account = $_POST['account'];
$password = @$_POST['password'];
$verify_code = @$_POST['verify_code'];

// 3.判断是否为主动提交
$submit = @$_POST['submit'];
if ($submit) {

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
        echo json_encode(['code' => 401, 'msg' => '无法为空用户进行验证!']);
        isEntry404();
        die;
    }

    // 检查在缓冲消息中的账号和请求的账号是否一致
    $res = $db->getRow("select id,verify_msg from $table where account=$account");
    if (!$res) {
        $db->close();
        echo json_encode(['code' => 401, 'msg' => '邮箱不匹配，请检查邮箱是否为注册时填写的邮箱！']);
        header('HTTP/1.1 401.1 Unauthorized');
        die;
    }

    // 拆分数据：0=>account, 1=>code, 2=>time
    $verify_info = explode(',', $res['verify_msg']);

    // 如果有输入验证码
    if ($verify_code) {
        // 如果不一致的就报错
        if (!$verify_info || $verify_info[1] != $verify_code) {
            $db->close();
            echo json_encode(['code' => 401, 'msg' => '验证码不正确！']);
            header('HTTP/1.1 401.1 Unauthorized');
            die;
        }
    } else {
        $db->close();
        echo json_encode(['code' => 401, 'msg' => '请重新获取验证码！']);
        header('HTTP/1.1 401.1 Unauthorized');
        die;
    }

    // 默认超时时间为5分钟
    if (time() - $verify_info[2] > 300) {
        $db->close();
        echo json_encode(['code' => 401, 'msg' => '验证码失效，请重新获取！']);
        header('HTTP/1.1 401.1 Unauthorized');
        die;
    }

    // 密码必须符合要求
    if (!$password || strlen($password) < 6 || strlen($password) > 16) {
        $db->close();
        echo json_encode(['code' => 401, 'msg' => '新密码长度必须为6-16个字符！']);
        header('HTTP/1.1 401.1 Unauthorized');
        die;
    }

    // 4.根据不同的提交信息进行不同的操作
    if ($submit === 'forget_password') {
        if ($obj && $account) {
            $db->update($table, ['password' => $password], "account='{$verify_info[0]}'", 'id=' . $res['id']);
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
    } else if ($submit === 'register_account') {
        $adminname = @$_POST['adminname'];
        if (!isValidString($adminname) || strlen($adminname) > 16) {
            echo '<script>alert("管理员名称不合法，请重新输入！"); history.go(-1); </script>';
            die;
        }
        if (!$account) {
            echo '<script>alert("邮箱地址不能为空！"); history.go(-1); </script>';
            die;
        }

        // 如果邮箱存在，则不允许重复注册
        $res = $db->getRow("select account from admininfo where account=$verify_info[0]");
        if ($res) {
            $db->close();
            echo json_encode(['code' => 401, 'msg' => '账号已经存在，请重新注册！']);
            header('HTTP/1.1 401.1 Unauthorized');
            die;
        }

        $db->insert('admininfo', ['account' => $account, 'name' => $adminname, 'password' => $password]);
        $db->close();
        echo '<script>alert("注册成功！点击确认进入登陆页面");location.href = "http://bookstudy.com/login_page.php"</script>';
        // todo：暂时不加审核功能
        // echo '<script>alert("注册成功！系统管理员审核中...\n一般审核时间为1-2天，请您耐心等待。");location.href = "http://bookstudy.com/login_page.php"</script>';
    }
}
