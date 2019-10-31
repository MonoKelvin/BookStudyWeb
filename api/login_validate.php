<?php
require_once(dirname(__FILE__) . '\utility.php');

refreshCheck();

$db = MySqlAPI::getInstance();
$account = $_POST['account'];
$password = $_POST['password'];

if ($db == null) {
    echo '<script> alert("数据库连接失败"); history.go(-1);</script>';
} else {
    $res = $db->getRow(
        "select ui.id,name,account,avatar,online
        from userinfo as ui
        join userprivate as up
        where account = '$account'
        and password = '$password'"
    );

    if ($res) {
        if($res['online'] == 1){
            $db->close();
            echo '<script>alert("该账号已在另一台设备登录，不可重复登录！"); history.go(-1); </script>';
            die;
        }

        // 获取登录信息
        $_SESSION['id'] = $res['id'];
        $_SESSION['name'] = $res['name'];
        $_SESSION['account'] = $account;
        $_SESSION['password'] = $password;
        $_SESSION['avatar'] = $res['avatar'];

        // 登陆后online置为1，表示在该设备登录了
        $db->query('update userprivate set online=1 where id=' . $res['id']);

        echo '<script>window.location="/../index.php";</script>';
    } else {
        echo '<script>alert("用户名或密码错误！"); history.go(-1); </script>';
    }
}

$db->close();
