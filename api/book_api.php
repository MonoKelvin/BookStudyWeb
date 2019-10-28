<?php

require_once('mysql_api.php');
require_once('utility.php');

/* 根据ISBN号获得数据库中书的数据
 * @param $isbn ISBN分类号
 * @return 封装图书的json格式数据
 */
function getBookFromISBN($isbn)
{
    $db = MySqlAPI::getInstance();
    $sql = "select * from bookinfo where isbn=" . $isbn;
    $res = $db->getRow($sql);
    $db->close();

    isEntry404(($res == null));

    $res = json_encode($res);
    return $res;
}

/* 根据书名获得数据库中书的数据，可能返回多个
 * @param $title 书名，可以只是部分
 * @return 封装图书的json格式数据
 */
function getBooksByTitle($title)
{
    $db = MySqlAPI::getInstance();
    $sql = "select * from bookinfo where title like '*" . $title . "*'";
    $res = $db->getAll($sql);
    $db->close();

    isEntry404(($res == null));

    $res = json_encode(res);
    return $res;
}

/**
 * 根据数量来获取书的基本信息(后台展示用)
 * @param int $number 要一次拿出几个数据
 * @param int $first 从结果中的第几个位置拿，对分页展示有效
 * @return int 从数据库中去除的书，取出来的数据 <= $number
 */
function getBookInfoWithNumber($first = 0, $number = 50)
{
    $db = MySqlAPI::getInstance();
    $res = $db->getAll(
        "select bi.id,bi.title,bi.remaining,COUNT(ub.b_id) lent
        from bookinfo as bi
        left outer join userbooks as ub
        on bi.id = ub.b_id
        group by bi.id limit $first, $number"
    );

    $db->close();

    return $res;
}

/* 根据书ID号获得数据库中书的详细数据
 * @param $id 书的 ID 号
 * @return 封装图书的json格式数据
 */
function getBookInfoById($id)
{
    $db = MySqlAPI::getInstance();
    $res = $db->getRow(
        "select * from
        bookinfo as bi
        join bookdetail as bd
        on bi.id = bd.id and bi.id = " . $id
    );
    $db->close();

    isEntry404(($res == null));

    return $res;
}


function storeBookFromDouBan($book_json)
{
    $json_obj = json_decode($book_json, true);
    isEntry404($json_obj == null || $json_obj == false);

    // 存储图书的图片
    $img_url = $json_obj['image'];
    $img_file_name = substr($img_url, strripos($img_url, '/') + 1, 100);
    $local_img_path = "http://api.bookstudy.com/book/image/$img_file_name";
    downloadNetworkFile($img_url, dirname(__FILE__)."/../bookstudy_api/book/image/$img_file_name");

    // 打开数据库
    $db = MySqlAPI::getInstance();

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

/**
 * 获得书库里所有书的数量
 * @param bool $merge_identical 是否重复计算相同的书数目
 * @return int 返回书库里书的数量
 */
function getBooksNumber($calc_indentical = false)
{
    $db = MySqlAPI::getInstance();

    if ($calc_indentical == false) {
        $res = $db->getRow("select SUM(remaining) from bookinfo");
        $res = $res['SUM(remaining)'];
    } else {
        $res = $db->getRow("select COUNT(*) from bookinfo where remaining >= 1");
        $res = $res['COUNT(*)'];
    }
    $db->close();

    return $res;
}

/**
 * 获得书库里所有被借出书的数量
 * @return int 返回书库里被借出书的数量
 */
function getBooksLentNumber()
{
    $db = MySqlAPI::getInstance();
    $res = $db->getRow("select SUM(lent) from bookdetail");
    var_dump($res);

    $db->close();

    isEntry404($res == null);

    return $res['SUM(lent)'];
}
