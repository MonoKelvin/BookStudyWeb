<?php
require_once(dirname(__FILE__) . '\phpmailer_config.php');

/******************************************************************************
 *
 * 目前仅支持QQ邮箱发送邮件，如需支持更多类型，可以使用工厂模式动态生成邮件类
 * 比如基类为 IMail 包括初始化设置、配置SMTP内容等虚方法，实现该接口就可制定邮件发送类
 *
 ******************************************************************************/

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
    $mail = getMailObject();

    $mail->addAddress($who);
    $mail->Subject = $subject;
    $mail->Body = $htmlBody;

    $status = $mail->send();
    unset($mail);

    return $status;
}
