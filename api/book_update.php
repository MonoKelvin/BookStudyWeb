<?php

require_once(dirname(__FILE__) . '/mysql_api.php');

$id = @$_POST['id'] ? $_POST['id'] : -1;
if ($id > 0) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $pages = $_POST['pages'];
    $pubdate = $_POST['pubdate'];
    $summary = $_POST['summary'];
    $translator = $_POST['translator'];

    $isbn13 = $_POST['isbn13'];
    $subtitle = $_POST['subtitle'];
    $origin_title = $_POST['origin_title'];
    $binding = $_POST['binding'];
    $tags = $_POST['tags'];
    $author_intro = $_POST['author_intro'];
    $catalog = $_POST['catalog'];

    var_dump($tags);
    return;

    $db = MySqlAPI::getInstance();

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
    $res = $db->update('bookinfo', $datas, "id=$id");

    $datas = [
        'isbn13' => $_POST['isbn13'],
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
    $res = $db->update('bookinfo', $datas, "id=$id");

    var_dump($db->getRow('select * from bookinfo as bi join bookdetail where bi.id=' . $id));
    $db->close();
}
