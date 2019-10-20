<?php

require_once('../api/MySqlAPI.php');

$acc = '';
$pwd = '';

if (isset($_POST['account'])) {
    $acc = $_POST['account'];
}
if (isset($_POST['password'])) {
    $pwd = $_POST['password'];
}
if ($acc == '' || $pwd == '') {
    header('HTTP/1.1 401.1 Unauthorized');
    return '';
} else {
    $return_data = replyWithUserPrivateInfo($acc, $pwd);
    if ($return_data == null) {
        header('HTTP/1.1 401.1 Unauthorized');
    }
    echo $return_data;
    return $return_data;
}


function replyWithUserPrivateInfo($account, $password)
{
    if ($account == null || $password == null) {
        header('HTTP/1.1 401.1 Unauthorized');
        return null;
    }

    // 获得数据库实例
    $db = MySqlAPI::getInstance();

    // 找到账号密码对应的用户，主要获取它的id
    $sql = sprintf("select * from userprivate where account='%s' and password='%s' limit 1", $account, $password);
    $res = $db->getRow($sql);

    if ($res == null) {
        header('HTTP/1.1 401.1 Unauthorized');
        return null;
    }

    // 找到id对应的用户
    $sqlFindUser = 'select * from userinfo where id=' . $res['id'];
    $res = array_merge($res, $db->getRow($sqlFindUser));

    // 关闭数据库连接
    $db->close();

    return json_encode($res);
}
