<?php
require_once(dirname(__FILE__) . '\user_api.php');

if (isset($_GET['page'])) {
    if ($_GET['page'] > 0) {
        getUsersItem($_GET['page']);
    } else {
        isEntry404(true);
    }
} else {
    getUsersItem(1);
}

function getUsersItem($page = 1)
{
    $fetch_num = 10;
    $users_arr = getUserInfoWithNumber($page * $fetch_num - $fetch_num, $fetch_num);

    $user_no = ($page - 1) * $fetch_num + 1;
    $resultStr = '';
    foreach ($users_arr as $user) {
        $htmlStr = '';
        $id = $user['id'];
        $name = $user['name'];
        $account = $user['account'];
        $password = $user['password'];
        $online = $user['online'];

        $temp_file = dirname(__FILE__) . '/../html/template/user_info_item.html';
        $fp = fopen($temp_file, 'r');
        $htmlStr = fread($fp, filesize($temp_file));
        fclose($fp);

        // 替换内容，即动态生成 html的内容
        $htmlStr = str_replace('{user_no}', $user_no, $htmlStr);
        $htmlStr = str_replace('{id}', $id, $htmlStr);
        $htmlStr = str_replace('{name}', $name, $htmlStr);
        $htmlStr = str_replace('{account}', $account, $htmlStr);
        $htmlStr = str_replace('{password}', $password, $htmlStr);
        $htmlStr = str_replace('{online}', $online ? '#54e69d' : '#ff7676', $htmlStr);
        $user_no++;

        $resultStr .= $htmlStr;
    }

    $user_num = getUsersNumber();
    $data = [
        'user_num' => $user_num,
        'item_pre_page' => $fetch_num,
        'data' => $resultStr,
    ];
    reply(200, 'success', $data);
}
