<?php
header("content-type:text/html;charset=utf-8");
require_once $_SERVER['DOCUMENT_ROOT'] . "/common/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-article.php";
session_start();
if (!empty($_SESSION['ID'])) {
    if (!empty($_SESSION['Role']) && ($_SESSION['Role'] == 'Admin' || $_SESSION['Role'] == 'Root')) {
        $article = new Article();
        $audit   = $article->LoaderTotal('', '', 'pending');
    } else {
        PageJump("/user/home.php");
    }
} else {
    PageJump("/user/login.php?url={$_SERVER['PHP_SELF']}");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>网站管理</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">
	<link rel="bookmark" type="image/x-icon" href="../favicon.ico">
    <link rel="stylesheet" type="text/css" href="../css/menu.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
</head>
<body>
<?php include "../includes/header.inc.php";?>
<div class="container admin">
	<div class="box">
		<div class="admin-box">
	        <a href="audit.php">机构审核(<?php echo $audit; ?>)</a>
	        <a class="on" href="article.php">机构管理</a>
	        <a href="manage.php">网站管理</a>
	        <a href="<?php echo $_SERVER['PHP_SELF']; ?>">其他</a>
	    </div>
	    <div class="html-box">
	    	<div>
	    		<h1>欢迎进入黑桃Lab管理系统</h1>
	    	</div>
		</div>
	</div>
</div>
<?php include "../includes/footer.inc.php";?>
</body>
</html>
