<?php
require_once('../api/UserAPI.php');

$users_arr = getUserInfoWithNumber();
if ($users_arr == null) {
    return;
}

foreach ($users_arr as $user) {
    $id = $user['u_id'];
    $name = $user['u_name'];
    $account = $user['u_account'];
    $password = $user['u_password'];
    $online = $user['u_online'];

    $temp_file = "template/temp.html";
    $fp = fopen($temp_file, "r"); // 只读打开模板
    $str = fread($fp, filesize($temp_file)); // 读取模板中内容

    // 替换内容，即动态生成 html的内容
    $str = str_replace("{id}", $id, $str);
    $str = str_replace("{name}", $name, $str);
    $str = str_replace("{account}", $account, $str);
    $str = str_replace("{password}", $password, $str);
    $str = str_replace("{online}", $online ? '#54e69d' : '#ff7676', $str);

    fclose($fp);

    echo $str;
}
