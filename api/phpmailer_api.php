<?php
require_once(dirname(__FILE__) . '\phpmailer_config.php');
require_once(dirname(__FILE__) . '\utility.php');

/******************************************************************************
 *
 * 目前仅支持QQ邮箱发送邮件，如需支持更多类型，可以使用工厂模式动态生成邮件类
 * 比如基类为 IMail 包括初始化设置、配置SMTP内容等虚方法，实现该接口就可制定邮件发送类
 *
 ******************************************************************************/

// 获得提交信息，只有用户主动提交才能获取验证码
$submit = @$_POST['submit'];

// 获得要取得验证码的对象，一般为用户和管理员
$obj = @$_GET['obj'];

if ($submit === 'get_verify_code') {
    if ($obj) {
        // 生成随机的验证码，并记录:邮件 + 时间，即形式为`account,code,time`
        $code = random_int(10000, 999999);
        $verify_msg = $_POST['account'] . ",$code," . time();

        $db = MySqlAPI::getInstance();

        // 把验证消息写入数据库的用于缓冲信息的字段
        if ($obj === 'admin') {
            $obj = 'admininfo';
        } else if ($obj === 'user') {
            $obj = 'userprivate';
        }
        $res = $db->getRow("select id from $obj where account=$account");
        if ($res) {
            $db->query("update $obj set verify_msg=$verify_msg where id={$res['id']}");
        } else {
            $db->close();
            reply(404, 'failed', ['msg' => '该账号尚未注册！']);
            header('HTTP/1.1 404 NOT FOUND');
            die;
        }

        $db->close();

        // 发送邮件，无论成功与否都不返回额外信息，因为信息都在缓冲字段里
        if (sendMail($_POST['account'], '验证码', createHtmlMailWithVerifyCode($code))) {
            reply(200, 'success', ['msg' => 'null']);
        } else {
            reply(666, 'failed', ['msg' => 'null']);
        }

        exit(0);
    }
}

// 非法访问进入404页面
isEntry404();

/**
 * 创建带有html形式的验证码邮件
 * @param string|int $code 要显示的验证码
 * @return string 得到html形式的邮件内容
 */
function createHtmlMailWithVerifyCode($code)
{
    // 读文件模板
    $tempFile = dirname(__FILE__) . '\..\html\template\reset_password.html';
    $file = fopen($tempFile, 'r');
    $htmlStr = fread($file, filesize($tempFile));
    fclose($file);

    // 替换内容
    $htmlStr = str_replace('{code}', $code, $htmlStr);

    return $htmlStr;
}

/**
 * 创建一个邮件对象
 * @return PHPMailer 返回邮件对象
 * @note 目前只支持qq邮箱
 * @see PHPMailer
 */
function getMailObject()
{
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->isHTML(true);
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->CharSet = 'UTF-8';

    $mail->Host = PHPMAIL_MAILHOST;
    $mail->Port = PHPMAIL_MAILPORT;
    $mail->FromName = PHPMAIL_NICKNAME;
    $mail->Username = PHPMAIL_USERNAME;
    $mail->Password = PHPMAIL_PASSWORD;
    $mail->From = PHPMAIL_USERMAIL;

    return $mail;
}

/**
 * 发送邮件
 * @param string $who 要发送的对方邮箱，比如 xxxx@qq.com
 * @param string $subject 发送邮件的主题
 * @param string $htmlBody 要在邮件中显示的html内容
 * @return bool 返回是否发送成功
 * @note 目前只支持qq邮箱
 */
function sendMail($who, $subject, $htmlBody)
{
    if (empty($htmlBody)) {
        return false;
    }

    $mail = getMailObject();

    $mail->addAddress($who);
    $mail->Subject = $subject;
    $mail->Body = $htmlBody;

    $status = $mail->send();

    unset($mail);
    return $status;
}
