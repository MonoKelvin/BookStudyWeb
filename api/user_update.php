<?php
require_once(dirname(__FILE__) . '/utility.php');

refreshCheck();

if (isset($_POST['submit']) && $_POST['submit'] === 'submit') {

    if (!isValidString($_POST['name'])) {
        echo '<script>alert("用户名不合法，请重新输入！");history.go(-1);</script>';
        die;
    }
    if (!isValidString($_POST['account'])) {
        echo '<script>alert("账号不合法，请重新输入！");history.go(-1);</script>';
        die;
    }
    if (!isValidString($_POST['password'])) {
        echo '<script>alert("密码不合法，请重新输入！");history.go(-1);</script>';
        die;
    }
    if (strlen($_POST['name']) > 16) {
        echo '<script>alert("用户名长度须控制在16个字符内，请重新输入！");history.go(-1);</script>';
        die;
    }
    if (strlen($_POST['account']) > 32) {
        echo '<script>alert("账号长度须控制在32个字符内，请重新输入！");history.go(-1);</script>';
        die;
    }
    if (strlen($_POST['password']) < 6 || strlen($_POST['password']) > 16) {
        echo '<script>alert("密码长度须控制在6-16个字符内，请重新输入！");history.go(-1);</script>';
        die;
    }

    $id = @$_POST['id'] ? $_POST['id'] : -1;
    if ($id > 0) {
        $db = MySqlAPI::getInstance();
        if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
            $ori_image = $db->getRow('select avatar from userinfo where id=' . $id)['avatar'];
            $ori_image = substr($ori_image, strripos($ori_image, '/') + 1, 100);

            $save_path = dirname(__FILE__) . '/../../bookstudy_api/user/image/' . $ori_image;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $save_path)) {
                $db->close();
                unset($_FILES['image']);
                die('头像上传失败！');
            }
        }

        // 先更新基本信息
        $db->update('userinfo', ['name' => $_POST['name']], "id=$id");

        // 再更新详情
        $datas = [
            'account' => $_POST['account'],
            'password' => $_POST['password']
        ];
        $db->update('userprivate', $datas, "id=$id");

        $db->close();

        // 释放临时文件
        unset($_FILES['image']);
    }

    // echo "<script>location.href='{$_SERVER['HTTP_REFERER']}';</script>";
    header('location:/../user_info_page.php?id=' . $id);
} else {
    isEntry404(true);
}
