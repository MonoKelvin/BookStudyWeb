<?php

require_once(dirname(__FILE__) . '/mysql_api.php');
require_once(dirname(__FILE__) . '/utility.php');

var_dump($_FILES['image']['name']);

$id = @$_POST['id'] ? $_POST['id'] : -1;
if ($id > 0) {

    $db = MySqlAPI::getInstance();
    $image = $_POST['image'];
    var_dump($image);
    $ori_image = $db->getRow('select image from bookinfo where id=' . $id)['image'];

    // 更换图片后就下载一份到库中
    if ($image != $ori_image) {
        $ori_image = substr($ori_image, strripos($ori_image, '/') + 1, 100);    //原图片名
        $sava_path = dirname(__FILE__) . '/../bookstudy_api/book/image/' . $ori_image;
        if (!move_uploaded_file($_FILES['image'][0]['tmp_name'], $sava_path)) {
            die('书籍封面上传失败！');
        }
    }
    $db->close();
    unset($_FILES['image']);
    return;

    $datas = [
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'publisher' => $_POST['publisher'],
        'pages' => $_POST['pages'],
        'pubdate' => $_POST['pubdate'],
        'summary' => $_POST['summary'],
        'translator' => $_POST['translator']
    ];
    foreach ($datas as $key => $value) {
        if ($value == '') {
            $datas[$key] = null;
        }
    }
    $db->update('bookinfo', $datas, "id=$id");

    $datas = [
        'subtitle' => $_POST['subtitle'],
        'origin_title' => $_POST['origin_title'],
        'binding' => $_POST['binding'],
        'tags' => $_POST['tags'],
        'author_intro' => $_POST['author_intro'],
        'catalog' => $_POST['catalog']
    ];
    foreach ($datas as $key => $value) {
        if ($value == '') {
            $datas[$key] = null;
        }
    }
    $db->update('bookdetail', $datas, "id=$id");

    var_dump($db->getRow('select * from bookinfo as bi join bookdetail where bi.id=' . $id));
    $db->close();
}
