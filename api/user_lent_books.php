<?php
require_once('mysql_api.php');
require_once('utility.php');

if (isset($_GET['id'])) {
    getUserLentBooks($_GET['id']);
} else if(isset($_GET['book_id'])) {
    getUsersLentTheBook($_GET['book_id']);
} else {
    isEntry404(true);
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
    $db = MySqlAPI::getInstance();
    $data = $db->getAll(
        'select b_id,title,author,lent_time
        from userbooks as ub
        join bookinfo as bi
        on bi.id=ub.b_id and ub.u_id=' . $id
    );

    reply(200, 'success', $data);
}

function getUsersLentTheBook($book_id)
{
    $db = MySqlAPI::getInstance();
    $data = $db->getAll(
        'select u_id,name,lent_time
        from userbooks as ub
        join userinfo as ui
        on ui.id=ub.u_id and ub.b_id=' . $book_id
    );

    reply(200, 'success', $data);
}
