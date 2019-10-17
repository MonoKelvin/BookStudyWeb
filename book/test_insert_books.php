<?php

// require_once('../api/BookAPI.php');

// $res = MySqlAPI::getInstance()->useDataBase('bookdb')->getRow("select COUNT(*) from `bookinfo`");
// var_dump($res);
// $res = MySqlAPI::getInstance()->getRow("select COUNT(*) from `bookdetail`");
// var_dump($res);

// $url = 'https://api.douban.com/v2/book/isbn/9787507208740?apikey=0df993c66c0c636e29ecbb5344252a4a';
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// $response = curl_exec($ch);
// curl_close($ch);
// storeBookFromDouBan($response);
