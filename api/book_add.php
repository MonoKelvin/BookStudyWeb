<?php

require_once(dirname(__FILE__) . '\mysql_api.php');
require_once(dirname(__FILE__) . '\utility.php');

refreshCheck();

if (isset($_POST['submit']) && $_POST['submit'] === 'submit') {

    if (!isISBN($_POST['isbn13'])) {
        echo '<script>alert("ISBN13码不合法，请重新确认！");history.go(-1);</script>';
        die;
    }
    if (!isPositiveInteger($_POST['pages'], true)) {
        echo '<script>alert("页数必须为整数或不填！");history.go(-1);</script>';
        die;
    }
    if (!isPositiveInteger($_POST['remaining'])) {
        echo '<script>alert("新增数量必须为非负整数！");history.go(-1);</script>';
        die;
    }
    if (!isValidString($_POST['title'])) {
        echo '<script>alert("书名不合法，请重新输入！");history.go(-1);</script>';
        die;
    }
    if (!isValidString($_POST['author'])) {
        echo '<script>alert("作者名不合法，请重新输入！");history.go(-1);</script>';
        die;
    }
    if (!isValidDate($_POST['pubdate'], true)) {
        echo '<script>alert("出版日期不合法，请重新输入！");history.go(-1);</script>';
        die;
    }

    $db = MySqlAPI::getInstance();
    $the_id = $db->getRow('select MAX(id) as max from bookinfo')['max'];
    $the_id = $the_id + 1;

    if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
        $save_path = dirname(__FILE__) . "\..\..\bookstudy_api\book\image\\$the_id.jpg";
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $save_path)) {
            $db->close();
            unset($_FILES['image']);
            die('书籍封面上传失败！');
        }
    }

    $book_info = [
        'id' => $the_id,
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
        'id' => $the_id,
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
    echo '<script>location.href="/../book_info_page.php?id=' . $id . '";</script>';
} else {
    echo '<script>alert("请联系管理员进行操作");location.href="/../index.php"</script>';
}
