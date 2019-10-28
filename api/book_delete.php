<?php
require_once(dirname(__FILE__) . '\mysql_api.php');

if (isset($_POST['submit']) && $_POST['submit'] === 'submit') {
    $password = @$_POST['password'] ? $_POST['password'] : null;
    session_start();
    if ($password == $_SESSION['password']) {
        $db = MySqlAPI::getInstance();
        $img = $db->getRow('select image from bookinfo where id=' . $_GET['id'])['image'];
        $db->deleteOne('bookinfo', 'id=' . $_GET['id']);
        $db->close();

        $img = substr($img, strripos($img, '/') + 1, 100);
        $local_file = dirname(__FILE__) . '\..\..\bookstudy_api\book\image\\' . $img;
        if (file_exists($local_file)) {
            unlink($local_file);
        }

        echo '<script>history.go(-1);</script>';
    } else {
        echo '<script>alert("密码错误！您没有权限执行删除操作。");history.go(-1);</script>';
    }
} else {
    header('HTTP/1.1 401.1 Unauthorized');
    die('对不起，您没有权限访问！');
}
