<?php
require_once(dirname(__FILE__) . '\utility.php');

function getUserInfoWithNumber($first = 0, $number = 50, $key = null)
{
    if (!isValidString($key)) {
        $key = null;
    }

    $db = MySqlAPI::getInstance();

    if ($key != null) {
        $where = "name like '%$key%' or id='$key' or account like '%$key%'";
        $res = $db->getAll(
            "select SQL_CALC_FOUND_ROWS * from users_base_info
            where $where limit $first, $number"
        );
    } else {
        $res = $db->getAll("select SQL_CALC_FOUND_ROWS * from users_base_info limit $first, $number");
    }

    $res['count'] = $db->getRow("select found_rows() num")['num'];

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
    if ($res == null) {
        $db->close();
        isEntry404(true);
    }
    $temp_arr = $db->getAll("select b_id from userbooks where u_id=" . $id);
    $res['books'] = [];
    foreach ($temp_arr as $arr) {
        array_push($res['books'], $arr['b_id']);
    }
    $db->close();

    return $res;
}

/**
 * 获得用户库里所有用户的数量
 * @param bool $isOnline 是否只计算在线用户
 * @return int 返回所有用户的数量
 */
function getUsersNumber($isOnline = false)
{
    $db = MySqlAPI::getInstance();

    $res = 0;
    if ($isOnline) {
        $res = $db->getRow("select COUNT(id) from userinfo where online=1");
    } else {
        $res = $db->getRow("select COUNT(id) from userinfo");
    }
    $res = $res['COUNT(id)'];
    $db->close();

    return $res;
}
