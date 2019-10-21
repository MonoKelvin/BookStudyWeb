<?php
require_once(dirname(__FILE__) . '\..\api\book_api.php');

getBooksItem();

function getBooksItem() {
    $books_arr = getBookInfoWithNumber();
    if ($books_arr == null) {
        return null;
    }

    static $book_no = 1;
    foreach ($books_arr as $book) {
        $id = $book['id'];
        $title = $book['title'];
        $remaining = $book['remaining'];
        $lent = $book['lent'];

        $temp_file = dirname(__FILE__) . '\template\book_info_item.html';
        $fp = fopen($temp_file, 'r');
        $str = fread($fp, filesize($temp_file));
        fclose($fp);

        // 替换内容，即动态生成 html的内容
        $str = str_replace('{book_no}', $book_no, $str);
        $str = str_replace('{id}', $id, $str);
        $str = str_replace('{title}', $title, $str);
        $str = str_replace('{remaining}', $remaining, $str);
        $str = str_replace('{lent}', $lent, $str);
        $book_no++;

        echo $str;
    }
}
