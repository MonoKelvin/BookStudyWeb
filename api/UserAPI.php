<?php

require_once('MySqlAPI.php');

function getUserInfoWithNumber($number = 50)
{
    $db = MySqlAPI::getInstance();
    $res = $db->getAll(
        "select ui.u_id,ui.u_name,up.u_account,up.u_password,up.u_online
        from userinfo as ui
        join userprivate as up
        on ui.u_id = up.u_id order by ui.u_id  limit $number"
    );
    $db->close();

    return $res;
}
