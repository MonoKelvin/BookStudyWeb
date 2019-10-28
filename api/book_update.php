<?php

require_once(dirname(__FILE__) . '/mysql_api.php');
require_once(dirname(__FILE__) . '/utility.php');

if (isset($_POST['submit']) && $_POST['submit'] === 'submit') {
    $id = @$_POST['id'] ? $_POST['id'] : -1;
    if ($id > 0) {
        $db = MySqlAPI::getInstance();
        if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
            $ori_image = $db->getRow('select image from bookinfo where id=' . $id)['image'];
            $ori_image = substr($ori_image, strripos($ori_image, '/') + 1, 100);

            $save_path = dirname(__FILE__) . '/../../bookstudy_api/book/image/' . $ori_image;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $save_path)) {
                $db->close();
                unset($_FILES['image']);
                die('书籍封面上传失败！');
            }
        }

        // 先更新基本信息
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

        // 再更新详情
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

        $db->close();

        // 释放临时文件
        unset($_FILES['image']);
    }

    echo "<script>location.href='{$_SERVER['HTTP_REFERER']}';</script>";
} else {
    isEntry404(true);
}
