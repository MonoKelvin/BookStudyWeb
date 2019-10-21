<?php

/**
 * Ajax应答请求
 * @param int $code 状态码
 * @param string $message 相关信息
 * @param array $res 应答返回json的数据
 */
function reply($code = 404, $message = 'error', $res = [])
{
    $res = array('code' => $code, 'message' => $message, 'data' => $res);
    echo json_encode($res);
}

/**
 * 下载网络文件
 * @param string $file_url 网络文件的地址
 * @param string $save_to 要保存下载下来的文件的路径
 */
function downloadNetworkFile($file_url, $save_to)
{
    $content = file_get_contents($file_url);
    if (empty($content) || $content == false) {
        die('file_download_filed');
    }
    file_put_contents($save_to, $content);
}

/**
 * 是否要进入404页面
 * @param bool $condition 进入404页面的条件，为`true`则进入
 */
function isEntry404($condition)
{
    if ($condition) {
        require_once(dirname(__FILE__) . '\..\pages_error_404.html');
        header('HTTP/1.1 404 Not Found');
        header('Status: 404 Not Found');
        exit;
    }
}

/**
 * 判断用户（管理员）是否已经登录
 *
 */
function isLogedIn()
{

}
