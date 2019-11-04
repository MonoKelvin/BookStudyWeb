<?php

require_once(dirname(__FILE__) . '\..\api\mysql_api.php');
require_once(dirname(__FILE__) . '\..\api\utility.php');

$booksFile = dirname(__FILE__) . '\books.txt';
$fp = fopen($booksFile, 'r');
$booksArray = fread($fp, filesize($booksFile));
fclose($fp);
$booksArray = explode(',', $booksArray);

// 打开数据库
$db = MySqlAPI::getInstance();
$book_ids = $db->getAll('select id from bookinfo');
$ids = [];
foreach ($book_ids as $val) {
    $ids[$val['id']] = $val['id'];
}

foreach ($booksArray as $book) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $book);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    $json_obj = json_decode($response, true);
    $ret_code = @$json_obj['code'] ? $json_obj['code'] : 200;
    if ($json_obj == null || $json_obj == false || $ret_code != 200) {
        $db->close();
        die('json_prase_is_failed');
    }

    if (isset($ids[$json_obj['id']])) {
        continue;
    }

    $img_url = $json_obj['image'];
    $img_file_name = $json_obj['id'] . substr($img_url, strripos($img_url, '.'));
    $local_img_path = 'http://api.bookstudy.com/book/image/' . $img_file_name;
    downloadNetworkFile($img_url, $local_img_path);

    // 基本信息的获取
    $author = implode(",", $json_obj['author']);
    $translator = implode(",", $json_obj['translator']);
    $pages = $json_obj['pages'];
    if (!is_numeric($pages)) {
        preg_match('/\d+/', $pages, $pages);
        $pages = $pages[0];
    }
    $data = [
        'id' => $json_obj['id'],
        'title' => addslashes($json_obj['title']),
        'author' => addslashes($author),
        'publisher' => addslashes($json_obj['publisher']),
        'pages' => $pages,
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
        'catalog' => addslashes($json_obj['catalog']),
        'price' => $json_obj['price']
    ];
    $res = $db->insert('bookdetail', $data);
}

$db->close();
