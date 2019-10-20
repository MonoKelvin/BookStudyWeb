<?php

require_once('../api/MySqlAPI.php');

function replyWithUserID()
{
    $res = ['error' => 'parameter is invalid or address is wrong'];

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        if ($id == null) {
            header('HTTP/1.1 404 Not Found');
            return ['error' => 'id can not be set to null'];
        }
        if (!is_numeric($id) || $id <= 0) {
            header('HTTP/1.1 404 Not Found');
            return ['error' => 'id is invalid'];
        }

        $db = MySqlAPI::getInstance();
        $sql = "select * from userinfo where id=" . $id;
        $res = $db->getRow($sql);
        $db->close();

        if ($res == null) {
            header('HTTP/1.1 404 Not Found');
            $res = ['id' => -1, 'name' => 'unknown', 'error' => 'user id is not exists'];
        }
    }
    return $res;
}

$json_res = json_encode(replyWithUserID());
echo $json_res;
return $json_res;
