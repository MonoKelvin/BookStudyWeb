<?php

function isPostValueValid($post_param)
{
    if (isset($_POST[$post_param])) {
        return $_POST[$post_param];
    } else {
        return null;
    }
}

/**
 * 下载网络文件
 * @param string $file_url 网络文件的地址
 * @param string $save_to 要保存下载下来的文件的路径
 */
function downloadNetworkFile($file_url, $save_to)
{
    $content = file_get_contents($file_url);
    if(empty($content) || $content == false) {
        die('file_download_filed');
    }
    file_put_contents($save_to, $content);
}
