<?php
require_once('mysql_api.php');
require_once('utility.php');

if (isset($_GET['id'])) {
    getUserLentBooks($_GET['id']);
}
/**
 * 获得用户借的书
 *
 * @return array 返回的数据格式如下：
 * ```php
 * $data = [
 *     'online_num' => int,     // 用户在线数量
 *     'users_num' => int,      // 用户总数
 *     'remaining_num' => int,  // 书库剩余书本数量，包括重复
 *     'lent_num' => int        // 借出去的书本数量
 * ];
 * ```
 */
function getUserLentBooks($id)
{
    $data = [];

    $db = MySqlAPI::getInstance();
    $data = $db->getAll('select (b_id, lent_time) from userbooks where u_id=' . $id);

    var_dump($data);

    $book_infos = [];
    foreach ($data as $val) {
        $book_infos[] = $db->getRow('select (title, author) from bookinfo where id=' . $val['b_id']);
    }

    var_dump($book_infos);

    reply(200, 'success', $data);
}
