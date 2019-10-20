<?php
require_once('mysql_api.php');
require_once('utility.php');

if (isset($_GET['id'])) {
    // $user = getUserInfoById($_GET['id']);
    // if ($user['id'] == -1) {
    //     header('HTTP/1.1 404 Not Found');
    //     return;
    // }
    getUserLentBooks($_GET['id']);
} else {
    header('HTTP/1.1 404 Not Found');
    return;
}

/**
 * 获得用户借的书基本信息
 *
 * @return array 返回的数据格式如下：
 * ```php
 * $data = [
 *      [
 *          b_id,
 *          title,
 *          author,
 *          lent_time
 *      ],
 *      [
 *          b_id,
 *          title,
 *          author,
 *          lent_time
 *      ],
 *      ...
 * ];
 * ```
 */
function getUserLentBooks($id)
{
    $data = [];

    $db = MySqlAPI::getInstance();
    $data = $db->getAll(
        'select b_id,title,author,lent_time
        from userbooks as ub
        join bookinfo as bi
        on bi.id=ub.b_id and ub.u_id=' . $id
    );

    reply(200, 'success', $data);
}
