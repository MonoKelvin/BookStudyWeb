<?php

require_once('mysql_api.php');

function getUserInfoWithNumber($number = 50)
{
    $db = MySqlAPI::getInstance();
    $res = $db->getAll(
        "select ui.id,ui.name,up.account,up.password,up.online
        from userinfo as ui
        join userprivate as up
        on ui.id = up.id order by ui.id limit $number"
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
 *      'id'              // id号
 *      'name'            // 名字（昵称）
 *      'avatar'          // 头像地址
 *      'account'         // 账号
 *      'password'        // 密码
 *      'md5'             // md5验证码
 *      'books' => [      // 借的书id号
 *          0 => 'id',
 *          1 => 'id',
 *          ...
 *       ],
 * ]
 * ```
 */
function getUserInfoById($id)
{
    $db = MySqlAPI::getInstance();
    $res = $db->getRow(
        "select * from userinfo as ui
        join userprivate as up on ui.id=" . $id
    );
    if($res == null) {
        return ['id'=>'-1', 'msg' => 'user_not_found'];
    }
    $temp_arr = $db->getAll("select b_id from userbooks where u_id=" . $id);
    $res['books'] = [];
    foreach ($temp_arr as $arr) {
        array_push($res['books'], $arr['b_id']);
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
        $id = $user['id'];
        $name = $user['name'];
        $account = $user['account'];
        $password = $user['password'];
        $online = $user['online'];

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
        // $str = str_replace('{bg-color}', $online ? 'bg-green' : 'bg-red', $str);
        $str = str_replace('{number}', $order_num, $str);
        $order_num++;

        echo $str;
    }
}
