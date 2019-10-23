<?php
require_once(dirname(__FILE__) . '\mysql_api.php');

$db = MySqlAPI::getInstance();

$account = $_POST['account'];
$password = $_POST['password'];

if ($db == null) {
    echo '<script> alert("数据库连接失败"); history.go(-1);</script>';
    exit(0);
} else {
    $res = $db->getRow(
        "select ui.id,name,account,avatar
        from userinfo as ui
        join userprivate as up
        where account = '$account'
        and password = '$password'"
    );
    $db->close();

    if ($res) {
        session_start();
        $_SESSION['id'] = $res['id'];
        $_SESSION['name'] = $res['name'];
        $_SESSION['account'] = $account;
        $_SESSION['password'] = $password;
        $_SESSION['avatar'] = $res['avatar'];

        echo '<script>window.location="/../index.php";</script>';
    } else {
        echo '<script>alert("用户名或密码错误！"); history.go(-1); </script>';
    }
}
