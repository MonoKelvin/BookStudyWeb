<?php
require_once(dirname(__FILE__) . '\..\api\mysql_api.php');

$id = @$_POST['id'];
if ($id) {
    $db = MySqlAPI::getInstance();
    $res = $db->getAll(
        'select title,image
        from bookinfo as bi
        join userbooks as ub
        on bi.id=ub.b_id and ub.u_id=' . $id
    );

    $db->close();

    if ($res) {
        return json_encode($res);
    } else {
        header('HTTP/1.1 404 Not Found');
        return null;
    }
}
