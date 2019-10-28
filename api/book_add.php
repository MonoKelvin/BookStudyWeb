<?php

require_once(dirname(__FILE__) . '\mysql_api.php');

if (isset($_POST['submit']) && $_POST['submit'] === 'submit') {
    $db = MySqlAPI::getInstance();
    $the_id = $db->getRow('select MAX(id) as max from bookinfo')['max'];

    if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
        $save_path = dirname(__FILE__) . "\..\..\bookstudy_api\book\image\\$the_id.jpg";
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $save_path)) {
            $db->close();
            unset($_FILES['image']);
            die('书籍封面上传失败！');
        }
    }

    $book_info = [
        'id' => $the_id + 1,
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'publisher' => $_POST['publisher'],
        'pages' => ($_POST['pages'] > 0 && is_numeric($_POST['pages'])) ? $_POST['pages'] : 1,
        'pubdate' => $_POST['pubdate'],
        'image' => "http://api.bookstudy.com/book/image/$the_id.jpg",
        'summary' => $_POST['summary'],
        'translator' => $_POST['translator'],
        'remaining' => ($_POST['remaining'] > 0 && is_numeric($_POST['remaining'])) ? $_POST['remaining'] : 1
    ];
    foreach ($book_info as $key => $val) {
        if ($val == '') {
            $book_info[$key] = null;
        }
    }
    $db->insert('bookinfo', $book_info);

    $book_info = [
        'id' => $the_id + 1,
        'isbn13' => $_POST['isbn13'],
        'subtitle' => $_POST['subtitle'],
        'origin_title' => $_POST['origin_title'],
        'binding' => $_POST['binding'],
        'tags' => $_POST['tags'],
        'author_intro' => $_POST['author_intro'],
        'catalog' => $_POST['catalog']
    ];
    foreach ($book_info as $key => $val) {
        if ($val == '') {
            $book_info[$key] = null;
        }
    }
    $db->insert('bookdetail', $book_info);

    $db->close();
    unset($_FILES['image']);

    // echo "<script>location.href='{$_SERVER['HTTP_REFERER']}';</script>";
} else {
    echo '<script>alert("请联系管理员添加书籍");history.go(-1)</script>';
}
