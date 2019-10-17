<?php

require_once('../api/MySqlAPI.php');

$db = MySqlAPI::getInstance();
$res = $db->getAll('
    select ui.u_id,ui.u_name,up.u_account,up.u_password,up.u_online
    from userinfo as ui
    join userprivate as up
    on ui.u_id = up.u_id limit 20'
);
$db->close();

if($res == null) {
    header('HTTP/1.1 404 Not Found');
    die('查询用户失败');
}

var_dump($res);

