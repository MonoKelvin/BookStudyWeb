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
        "select id,account,password
        from userprivate
        where account = '$account'
        and password = '$password'"
    );
    $db->close();

    if ($res) {
        session_start();
        $_SESSION['account'] = $account;
        $_SESSION['id'] = $res['id'];

        echo '<script>window.location="/../index.php";</script>';
    } else {
        echo '<script>alert("用户名或密码错误！"); history.go(-1); </script>';
    }
}
