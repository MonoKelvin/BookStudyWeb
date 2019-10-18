<?php
require_once(dirname(__FILE__) . '\..\api\UserAPI.php');

$users_arr = getUserInfoWithNumber();
if ($users_arr == null) {
    return;
}

static $num = 1;
foreach ($users_arr as $user) {
    $id = $user['u_id'];
    $name = $user['u_name'];
    $account = $user['u_account'];
    $password = $user['u_password'];
    $online = $user['u_online'];

    $temp_file = dirname(__FILE__) . '\template\user_info_item.html';
    $fp = fopen($temp_file, 'r');
    $str = fread($fp, filesize($temp_file));
    fclose($fp);

    // 替换内容，即动态生成 html的内容
    $str = str_replace('{id}', $id, $str);
    $str = str_replace('{name}', $name, $str);
    $str = str_replace('{account}', $account, $str);
    $str = str_replace('{password}', $password, $str);
    $str = str_replace('{online}', $online ? '#54e69d' : '#ff7676', $str);
    $str = str_replace('{bg-color}', $online ? 'bg-green' : 'bg-red', $str);
    $str = str_replace('{number}', $num, $str);
    $num++;

    echo $str;
}
