<?php
require_once(dirname(__FILE__) . '/utility.php');

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
    if(strlen($_POST['title']) > 100 ) {
        echo '<script>alert("书名不允许超过100个字符，请重新输入！");history.go(-1);</script>';
        die;
    }
    if (strlen($_POST['subtitle']) > 100) {
        echo '<script>alert("副标题不允许超过100个字符，请重新输入！");history.go(-1);</script>';
        die;
    }
    if (strlen($_POST['origin_title']) > 100) {
        echo '<script>alert("原标题不允许超过100个字符，请重新输入！");history.go(-1);</script>';
        die;
    }
    if (strlen($_POST['author']) > 100) {
        echo '<script>alert("作者名不允许超过100个字符，请重新输入！");history.go(-1);</script>';
        die;
    }
    if (strlen($_POST['publisher']) > 64) {
        echo '<script>alert("出版社名不允许超过64个字符，请重新输入！");history.go(-1);</script>';
        die;
    }
    if (strlen($_POST['translator']) > 60) {
        echo '<script>alert("翻译不允许超过60个字符，请重新输入！");history.go(-1);</script>';
        die;
    }
    if (strlen($_POST['pages']) > 10) {
        echo '<script>alert("页数不允许超过10个数字，请重新输入！");history.go(-1);</script>';
        die;
    }
    if(strlen($_POST['binding']) > 8) {
        echo '<script>alert("装帧形式不允许超过8个字符，请重新输入！");history.go(-1);</script>';
        die;
    }
    $price = $_POST['price'];
    if (strlen($price) > 16) {
        echo '<script>alert("定价字符长度超过16个字符，请重新输入！");history.go(-1);</script>';
        die;
    }
    if (!is_numeric($price) && $price !== '') {
        preg_match('/\d+/', $price, $price);
        $pages = $pages[0];
        if (!is_numeric($price) && $price !== '') {
            echo '<script>alert("定价不合法，请重新输入！");history.go(-1);</script>';
            die;
        }
    }

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
            'catalog' => $_POST['catalog'],
            'price' => $price,
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

    header('location:/../book_info_page.php?id=' . $id);
} else {
    isEntry404(true);
}
