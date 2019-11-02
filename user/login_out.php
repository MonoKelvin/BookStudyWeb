<?php
require_once(dirname(__FILE__) . '\..\api\mysql_api.php');

$type = @$_POST['type'];
if ($type) {
    if ($type == 'login') {
        $acc = @$_POST['account'];
        $pwd = @$_POST['password'];

        if (!$acc || !$pwd) {
            header('HTTP/1.1 401.1 Unauthorized');
            return "401";
        } else {
            $db = MySqlAPI::getInstance();

            $res = $db->getRow(
                "select ui.id,name,md5,avatar,online
                from userinfo as ui
                join userprivate as up
                on ui.id=up.id and account='$acc' and password='$pwd'"
            );

            if (!$res) {
                $db->close();
                header('HTTP/1.1 401.1 Unauthorized');
                return '401';
            }

            if ($res['online'] == '1') {
                $db->close();
                header('HTTP 403 Forbidden');
                return '403';
            }

            // $db->query('update userprivate set online=1 where id=' . $res['id']);

            $db->close();

            $return_data = json_encode($res);
            echo $return_data;
        }
    } else if ($type == 'logout') {
        $db = MySqlAPI::getInstance();

        $id = @$_POST['id'];
        $res = null;

        if ($id) {
            $res = $db->query('update userprivate set online=0 where id=' . $id);
        }

        if (!$res) {
            header('HTTP/1.1 401.1 Unauthorized');
        }

        $db->close();
    }
}
