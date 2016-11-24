<?php
/*!
 * HeiTaoLab Library v1.1.3
 * 网站公共函数库文件
 *
 * http://www.heitaolab.com/
 * Copyright 2015, 2016 黑桃Lab
 * Date: 2016-3-10T19:30Z
 */

require_once $_SERVER['DOCUMENT_ROOT'] . "/PHPMailer/PHPMailerAutoload.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/config.ini.php";
//页面跳转
function PageJump($url)
{
    $url = '"' . $url . '"';
    die('<script type="text/javascript">window.location.href=' . $url . ';</script>');
}
//提示信息
function SetNotice($style)
{
    if (!empty($_SESSION['Notice'])) {
        switch ($style) {
            case "1":
                $NoticeBox = '<div id="Notice" style="color:red;font-size:17px;">' . $_SESSION['Notice'] . '</div>';
                echo $NoticeBox;
                break;
            case "2":
                $NoticeBox = '<div id="Notice" style="width: 260px;height: 40px;line-height: 40px;background: rgba(250,250,200,0.98);margin: -27px -135px;padding: 7px;position: fixed;top: 50%;left: 50%;color: #333;font-family: Arial, Helvetica, sans-serif;font-size: 14px;text-align: center;border: 1px solid #fff;box-shadow: 0 0 10px #ccc;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;word-wrap: break-word;word-break: break-all;overflow-wrap: break-word;z-index: 10;">' . $_SESSION['Notice'] . '</div>';
                echo $NoticeBox;
                echo '<script type="text/javascript">window.setTimeout(function(){document.getElementById("Notice").style.display="none";},3600);document.onclick=function(){document.getElementById("Notice").style.display="none";}</script>';
                break;
            case "3":
                $NoticeBox = '<div id="Notice" style="color:black;font-size:17px;">' . $_SESSION['Notice'] . '</div>';
                echo $NoticeBox;
                break;
            case "4":
                $NoticeBox = '<div id="Notice" style="width: 280px;height: 50px;line-height: 50px;background: rgba(250,250,200,0.98);margin: -33px -148px;padding: 7px;position: fixed;top: 50%;left: 50%;color: red;font-family: Arial, Helvetica, sans-serif;font-size: 22px;font-weight: bold;text-align: center;border: 1px solid #fff;box-shadow: 0 0 10px #ccc;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;word-wrap: break-word;word-break: break-all;overflow-wrap: break-word;z-index: 10;">' . $_SESSION['Notice'] . '</div>';
                echo $NoticeBox;
                echo '<script type="text/javascript">window.setTimeout(function(){document.getElementById("Notice").style.display="none";},3600);document.onclick=function(){document.getElementById("Notice").style.display="none";}</script>';
                break;
            default:
                break;
        }
        unset($_SESSION['Notice']);
    }
}
//发送邮件
$mailhost = MAIL_HOST;
$mailuser = MAIL_USER;
$mailpass = MAIL_PASSWORD;
$mailname = MAIL_NAME;
function SendMail($Address, $Subject, $Body)
{
    $mail = new PHPMailer;
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host       = $GLOBALS['mailhost']; // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true; // Enable SMTP authentication
    $mail->Username   = $GLOBALS['mailuser']; // SMTP username
    $mail->Password   = $GLOBALS['mailpass']; // SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587; // TCP port to connect to

    $mail->setFrom($GLOBALS['mailuser'], $GLOBALS['mailname']);
    $mail->addAddress($Address); // Name is optional
    $mail->addReplyTo($GLOBALS['mailuser'], $GLOBALS['mailname']);

    $mail->isHTML(true); // Set email format to HTML

    $mail->Subject = $Subject;
    $mail->Body    = $Body;
    $mail->AltBody = strip_tags($Body) . '你的客户端似乎不支持HTML,请使用支持的客户端或者在网页查看！';
    if ($mail->send()) {
        $CallBack = true;
    } else {
        $CallBack = false;
    }
    return $CallBack;
}
