<?php
require_once(dirname(__FILE__) . '\utility.php');

refreshCheck();

if (isset($_POST['submit']) && $_POST['submit'] === 'submit') {
    $password = @$_POST['password'] ? $_POST['password'] : null;
    if ($password && $password == $_SESSION['password']) {
        $db = MySqlAPI::getInstance();
        $db->deleteOne('userbooks', "u_id={$_POST['u_id']} and b_id = {$_POST['b_id']}");
        $db->close();

        // 返回上一页面并刷新
        echo "<script>location.href='" . $_SERVER["HTTP_REFERER"] . "';</script>";
    } else {
        echo '<script>alert("密码错误！您没有权限执行还书操作。");history.go(-1);</script>';
    }
} else {
    header('HTTP/1.1 401.1 Unauthorized');
    die('对不起，您没有权限执行！');
}
