<?php

require_once('MySqlAPI.php');
require_once('utility.php');

/* 根据ISBN号获得数据库中书的数据
 * @param $isbn ISBN分类号
 * @return 封装图书的json格式数据
 */
function getBookFromISBN($isbn)
{
    $db = MySqlAPI::getInstance();
    $db->useDataBase('bookdb');
    $sql = "select * from bookinfo where isbn=" . $isbn;
    $res = $db->getRow($sql);
    $db->close();

    if ($res == null) {
        header('HTTP/1.1 404 Not Found');
        $res = ['isbn' => $isbn, 'msg' => 'book_not_found'];
    }

    $res = json_encode($res);
    echo $res;
    return $res;
}

/* 根据书名获得数据库中书的数据，可能返回多个
 * @param $title 书名，可以只是部分
 * @return 封装图书的json格式数据
 */
function getBooksFromTitle($title)
{
    $db = MySqlAPI::getInstance();
    $db->useDataBase('bookdb');
    $sql = "select * from bookinfo where title like '*" . $title . "*'";
    $res = $db->getAll($sql);
    $db->close();

    if ($res == null) {
        header('HTTP/1.1 404 Not Found');
        $res = ['title' => $title, 'msg' => 'book_not_found'];
    } else {
        $res = json_encode(res);
    }

    echo $res;
    return $res;
}

/* 根据书ID号获得数据库中书的详细数据
 * @param $id 书的 ID 号
 * @return 封装图书的json格式数据
 */
function getBookDetailFromID($id)
{ }


function storeBookFromDouBan($book_json)
{
    // TODO: 实现存书的功能
    $json_obj = json_decode($book_json, true);
    if ($json_obj == null || $json_obj == false) {
        header('HTTP/1.1 404 Not Found');
        return false;
    };

    // 存储图书的图片
    $img_url = $json_obj['image'];
    $img_file_name = substr($img_url, strripos($img_url, '/') + 1, 100);
    $local_img_path = "http://api.bookstudy.com/book/image/$img_file_name";
    downloadNetworkFile($img_url, "../book/image/$img_file_name");

    // 打开数据库
    $db = MySqlAPI::getInstance();
    $db->useDataBase('bookdb');

    // 基本信息的获取
    $author = implode(",", $json_obj['author']);
    $translator = implode(",", $json_obj['translator']);
    $data = [
        'id' => $json_obj['id'],
        'title' => addslashes($json_obj['title']),
        'author' => addslashes($author),
        'publisher' => addslashes($json_obj['publisher']),
        'pages' => $json_obj['pages'] ? $json_obj['pages'] : 0,
        'pubdate' => $json_obj['pubdate'],
        'rating' => $json_obj['rating']['average'],
        'image' => $local_img_path,
        'summary' => $json_obj['summary'],
        'translator' => addslashes($translator)
    ];
    $res = $db->insert('bookinfo', $data);

    // 详细信息的获取
    $tags = '';
    foreach ($json_obj['tags'] as $val) {
        $tags .= $val['name'] . ',';
    }
    $tags = trim($tags, ',');
    $data = [
        'id' => $json_obj['id'],
        'isbn13' => $json_obj['isbn13'],
        'subtitle' => addslashes($json_obj['subtitle']),
        'origin_title' => addslashes($json_obj['origin_title']),
        'binding' => $json_obj['binding'],
        'tags' => addslashes($tags),
        'author_intro' => addslashes($json_obj['author_intro']),
        'catalog' => addslashes($json_obj['catalog'])
    ];
    $res = $db->insert('bookdetail', $data);

    // 关闭数据库并返回插入后影响的ID号
    $db->close();
    return $res;
}
