<?php
require_once(dirname(__FILE__) . '\phpmailer_config.php');
require_once(dirname(__FILE__) . '\utility.php');

/******************************************************************************
 *
 * 目前仅支持QQ邮箱发送邮件，如需支持更多类型，可以使用工厂模式动态生成邮件类
 * 比如基类为 IMail 包括初始化设置、配置SMTP内容等虚方法，实现该接口就可制定邮件发送类
 *
 ******************************************************************************/

// refreshCheck();

$submit = @$_POST['submit'];
if ($submit && $submit === 'get_verify_code') {
    $tempFile = dirname(__FILE__) . '\..\html\template\reset_password.html';
    $file = fopen($tempFile, 'r');
    $htmlStr = fread($file, filesize($tempFile));
    fclose($file);

    $code = random_int(10000, 999999);
    session_start();
    $_SESSION['verify_code'] = $_POST['email'] . ",$code," . time();
    $htmlStr = str_replace('{code}', $code, $htmlStr);

    if (sendMail($_POST['email'], '验证码', $htmlStr)) {
        reply(200, 'success', ['data' => 'null']);
    } else {
        reply(666, 'failed', ['data' => 'null']);
    }

    exit(0);
}

isEntry404(true);

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
