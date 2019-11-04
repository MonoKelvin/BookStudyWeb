<?php
require_once(dirname(__FILE__) . '\..\api\utility.php');

$name = @$_POST['name'];
$account = @$_POST['account'];
$password = @$_POST['password'];

if (!$name || !$account || !$password) {
    header('HTTP/1.1 401.1 Unauthorized');
    return null;
} else {
    if (!isValidString($name) || strlen($name) > 16) {
        echo json_encode(['code' => 401, 'msg' => '用户名无效！']);
        header('HTTP/1.1 401.1 Unauthorized');
        die;
    }
    if (!$account) {
        echo json_encode(['code' => 401, 'msg' => '账号无效！']);
        header('HTTP/1.1 401.1 Unauthorized');
        die;
    }
    if (!$password || strlen($password) < 6 || strlen($password) > 16) {
        echo json_encode(['code' => 401, 'msg' => '密码无效！']);
        header('HTTP/1.1 401.1 Unauthorized');
        die;
    }

    $db = MySqlAPI::getInstance();
    if ($db->getRow("select id from userprivate where account='$account'")) {
        $db->close();
        echo json_encode(['code' => 401, 'msg' => '账号已经存在！']);
        header('HTTP/1.1 401.1 Unauthorized');
        die;
    }

    $md5 = md5($name . $account . $password . time());
    $data = [
        'name' => $name, 'md5' => $md5,
        'avatar' => 'http://api.bookstudy.com/user/image/123626c8689420157ba4a7dbd47ce702.png'
    ];
    $id = $db->insert('userinfo', $data);
    $data = ['id' => $id, 'account' => $account, 'password' => $password];
    $db->insert('userprivate', $data);

    $db->close();

    echo json_encode(['code' => 200, 'msg' => 'SIGNUP_SUCCESSFULLY']);
}
