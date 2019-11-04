<?php
require_once(dirname(__FILE__) . '\..\api\mysql_api.php');

$id = @$_POST['id'];
if ($id) {
    $db = MySqlAPI::getInstance();
    $res = $db->getAll(
        "select id,title,image,lent_time
        from bookinfo as bi
        join userbooks as ub
        on bi.id=ub.b_id and ub.u_id=$id"
    );

    $db->close();

    if ($res) {
        echo json_encode($res);
    } else {
        echo json_encode(['msg' => 'no_books_lent']);
    }
}
