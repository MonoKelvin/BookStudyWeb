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

/**
 * 获得用户详细数据
 * @param int|string $id 用户ID
 * @return array 具体值如下：
 * ```php
 * [
 *      'u_avator' => '...',    // 头像地址
 *      'u_md5' => '...',       // md5验证码
 *      'u_books' => [          // 借的书的id号
 *          0 => 'id',
 *          1 => 'id',
 *          ...
 *       ],
 * ]
 * ```
 */
function getUserDetailFromID($id)
{
    $db = MySqlAPI::getInstance();
    $res = $db->getAll(
        "select ui.u_avator,ui.u_md5
        from userinfo as ui
        join userprivate as up
        on ui.u_id=" . $id
    );
    $temp_arr = $db->getAll("select b_id from userbooks where u_id=".$id);
    $res['u_books'] = [];
    foreach($temp_arr as $arr)
    {
        array_push($res['u_books'], $arr['id']);
    }
    $db->close();

    return $res;
}


function showBaseInfo($number = 20)
{
    $users_arr = getUserInfoWithNumber($number);
    if ($users_arr == null) {
        return;
    }

    static $order_num = 1;
    foreach ($users_arr as $user) {
        $id = $user['u_id'];
        $name = $user['u_name'];
        $account = $user['u_account'];
        $password = $user['u_password'];
        $online = $user['u_online'];

        $temp_file = dirname(__FILE__) . '/../html/template/user_info_item.html';
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
        $str = str_replace('{number}', $order_num, $str);
        $order_num++;

        echo $str;
    }
}
