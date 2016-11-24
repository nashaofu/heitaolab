<?php
header("content-type:text/html;charset=utf-8");
require_once $_SERVER['DOCUMENT_ROOT'] . "/common/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-manage.php";
$result = array();
$title  = '哎呀！内容被狗吃了！';
if (!empty($_GET['s']) && is_numeric($_GET['s'])) {
    $id     = trim($_GET['s']);
    $manage = new Manage();
    $result = $manage->Browser($id);
    if (!empty($result)) {
        $title = $result['Title'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>黑桃Lab支持-<?php echo $title; ?></title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link rel="bookmark" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" type="text/css" href="../css/menu.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="css/support.css">
</head>
<body class="read">
<?php include "../includes/header.inc.php";?>
<div class="container index">
    <form id="search" action="search.php" method="get">
        <img class="search-logo-img" src="../images/logo/logo.gif">
        <div class="search">
            <input id="keyword" class="text" type="search" name="search">
            <input class="button" type="submit" value="搜索">
        </div>
    </form>
    <?php if (!empty($result)): ?>
    <article>
        <h1 class="article-header"><?php echo $result['Title']; ?></h1>
        <div class="article-body"><?php echo htmlspecialchars_decode($result['Body'], ENT_QUOTES); ?></div>
        <div class="article-footer">
            <div><?php echo date('Y年m月d日', strtotime($result['Time'])); ?></div>
        </div>
        <div class="flag"></div>
    </article>
    <?php else: ?>
    <article>
        <div class="noresult"><span class="emoji">:(</span><span>哎呀！内容被狗吃了！</span></div>
        <div class="flag"></div>
    </article>
    <?php endif?>
</div>
<script type="text/javascript">
var search=document.getElementById('search');
var keyword=document.getElementById('keyword');
var blank= /(^\s*)|(\s*$)/g;
search.onsubmit=function(){
    keyword.value=keyword.value.replace(blank,'');
    if (keyword.value=='') {
        return false;
    }
}
</script>
<?php include "../includes/footer.inc.php";?>
</body>
</html>