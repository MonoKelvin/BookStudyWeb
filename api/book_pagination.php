<?php
require_once(dirname(__FILE__) . '\book_api.php');

if (isset($_GET['page'])) {
    if ($_GET['page'] > 0) {
        getBooksItem($_GET['page'], @$_GET['key']);
    } else {
        isEntry404(true);
    }
} else {
    getBooksItem(1);
}

function getBooksItem($page = 1, $key = null)
{
    $fetch_num = 20;
    $books_arr = getBookInfoWithNumber($page * $fetch_num - $fetch_num, $fetch_num, $key);

    $book_num = 0 + $books_arr['count'];
    unset($books_arr['count']);

    $book_no = ($page - 1) * $fetch_num + 1;
    $resultStr = '';
    foreach ($books_arr as $book) {
        $htmlStr = '';
        $id = $book['id'];
        $title = $book['title'];
        $author = $book['author'];
        $remaining = $book['remaining'];
        $lent = $book['lent'];

        $temp_file = dirname(__FILE__) . '\..\html\template\book_info_item.html';
        $fp = fopen($temp_file, 'r');
        $htmlStr = fread($fp, filesize($temp_file));
        fclose($fp);

        // 替换内容，即动态生成 html的内容
        $htmlStr = str_replace('{book_no}', $book_no, $htmlStr);
        $htmlStr = str_replace('{id}', $id, $htmlStr);
        $htmlStr = str_replace('{title}', $title, $htmlStr);
        $htmlStr = str_replace('{author}', $author, $htmlStr);
        $htmlStr = str_replace('{remaining}', $remaining, $htmlStr);
        $htmlStr = str_replace('{lent}', $lent, $htmlStr);
        $book_no++;

        $resultStr .= $htmlStr;
    }

    $data = [
        'book_num' => $book_num,
        'item_pre_page' => $fetch_num,
        'data' => $resultStr,
    ];
    reply(200, 'success', $data);
}
