<?php
require_once('mysql_api.php');
require_once('utility.php');

getUserAndBookStatistics();

/**
 * 获得用户和图书的统计数据
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
function getUserAndBookStatistics()
{
    $data = [];

    $db = MySqlAPI::getInstance();
    $data['online_num'] = $db->getRow('select SUM(u_online) from userprivate')['SUM(u_online)'];
    $data['users_num'] = $db->getRow('select COUNT(*) from userinfo')['COUNT(*)'];
    $data['remaining_num'] = $db->getRow('select SUM(remaining) from bookinfo')['SUM(remaining)'];
    $data['lent_num'] = $db->getRow('select SUM(lent) from bookdetail')['SUM(lent)'];
    $db->close();

    reply(200, 'success', $data);
}
