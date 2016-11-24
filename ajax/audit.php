<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-article.php";
session_start();
$msg = '';
if (empty($_SESSION['ID'])) {
    $msg = '请登录账号！';
}
if (empty($msg) && $_SESSION['Role'] != 'Root' && $_SESSION['Role'] != 'Admin') {
    $msg = '您没有足够权限！';
}
if (empty($msg) && !empty($_POST['aid']) && !empty($_POST['type'])) {
    if (!is_numeric($_POST['aid'])) {
        $msg = '提交信息有误！';
    }
    $article = new Article();
    if ($_POST['type'] == 'PASS' || $_POST['type'] == 'ONSHELF') {
        $msg = $article->Audit($_POST['aid'], 'publish');
    }
    if ($_POST['type'] == 'DENY') {
        $msg = $article->Audit($_POST['aid'], 'nopass');
    }
    if ($_POST['type'] == 'UNDERSHELF') {
        $msg = $article->Audit($_POST['aid'], 'undershelf');
    }
}
@header('Content-type: text/html; charset=utf-8');
echo $msg;
