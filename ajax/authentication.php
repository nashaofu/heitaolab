<?php
header("content-type:text/html;charset=utf-8");
require_once $_SERVER['DOCUMENT_ROOT'] . "/common/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/config.ini.php";
function CreatMail($Email, $type)
{
    switch ($type) {
        case '0':
            $Subject = "黑桃Lab账号验证";
            $code    = str_split("0123456789");
            $YZM     = "";
            for ($i = 0; $i < 6; $i++) {
                $YZM .= $code[rand(0, count($code) - 1)];
            }
            $_SESSION['YZM'] = $YZM;
            $time            = date('Y-m-d H:i:s', time());
            $Body            = "<p>您正在黑桃Lab使用该邮箱更改账号信息，请确保是您本人操做的！</p><p style='line-height:25px;font-size:25px;'>验证码：<span style='line-height:25px;font-size:23px;font-weight:bold;'>{$YZM}</span></p><p>如非本人操作请尽快联系客服！</p><p>{$time}</p>";
            $RegEx           = '/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/';
            preg_match($RegEx, $Email, $matches);
            break;
        case '1':
            $Subject = "黑桃Lab账号注册";
            $code    = str_split("0123456789");
            $YZM     = "";
            for ($i = 0; $i < 6; $i++) {
                $YZM .= $code[rand(0, count($code) - 1)];
            }
            $_SESSION['YZM'] = $YZM;
            $time            = date('Y-m-d H:i:s', time());
            $Body            = "<p>您正在黑桃Lab使用该邮箱注册，请确保是您本人操做的！</p><p style='line-height:25px;font-size:25px;'><div>验证码：<span style='line-height:25px;font-size:23px;font-weight:bold;'>{$YZM}</span></div></p><p>如非本人操作请尽快联系客服！</p><p><div><a href='http://www.heitaolab.com'>黑桃Lab</a></div></p><p>{$time}</p>";
            $RegEx           = '/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/';
            preg_match($RegEx, $Email, $matches);
            break;
    }
    return array('Email' => $matches[0], 'Subject' => $Subject, "Body" => $Body);
}
function SendCode()
{
    if (!empty($_POST['Mail'])) {
        $MailText = trim(strtolower(strip_tags($_POST['Mail'])));
        $RegEx    = '/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/';
        $Callback = '';
        if (preg_match($RegEx, $MailText)) {
            @session_start();
            $Link = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("数据库连接失败！请联系网站管理员进行处理！");
            mysqli_set_charset($Link, DB_CHARSET);
            $Table = 'user';
            if (!empty($_SESSION['ID'])) {
                $sql      = "SELECT `Email` FROM `{$Table}` WHERE `ID`={$_SESSION['ID']} AND `Email`='{$MailText}'";
                $Callback = 'NoMatch';
            } else {
                $sql      = "SELECT `Email` FROM `{$Table}` WHERE `Email`='{$MailText}'";
                $Callback = 'NoExist';
            }
            $query  = mysqli_query($Link, $sql);
            $result = mysqli_fetch_assoc($query);
            if (!empty($result)) {
                $Mail = CreatMail($MailText, "0");
                if (SendMail($Mail['Email'], $Mail['Subject'], $Mail['Body'])) {
                    $Callback = 'SendSuccess';
                } else {
                    $Callback = 'SendFail';
                }
            }
        } else {
            $Callback = 'FormatError';
        }
        return $Callback;
    }
}
echo SendCode();
function Register()
{
    if (!empty($_POST['UserName'])) {
        $MailText = trim(strtolower(strip_tags($_POST['UserName'])));
        $RegEx    = '/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/';
        $Callback = '';
        if (preg_match($RegEx, $MailText)) {
            @session_start();
            $_SESSION['UserName'] = $MailText;
            $Link                 = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("数据库连接失败！请联系网站管理员进行处理！");
            mysqli_set_charset($Link, DB_CHARSET);
            $Table = 'user';
            if (empty($_SESSION['ID'])) {
                $sql    = "SELECT `Email` FROM `{$Table}` WHERE `Email`='{$MailText}'";
                $query  = mysqli_query($Link, $sql);
                $result = mysqli_fetch_assoc($query);
                if (empty($result)) {
                    $Mail = CreatMail($MailText, "1");
                    if (SendMail($Mail['Email'], $Mail['Subject'], $Mail['Body'])) {
                        $Callback = 'SendSuccess';
                    } else {
                        $Callback = 'SendFail';
                    }
                } else {
                    $Callback = 'Exist';
                }
            } else {
                $Callback = 'SESSIONError';
            }
        } else {
            $Callback = 'FormatError';
        }
        return $Callback;
    }
}
echo Register();
