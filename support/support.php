<?php
header("content-type:text/html;charset=utf-8");
require_once $_SERVER['DOCUMENT_ROOT'] . "/common/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-manage.php";
$manage = new Manage();
$help   = $manage->Loader('help', 'true', 0, 10, 'HitCount');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>黑桃Lab支持</title>
	<link rel="icon" type="image/x-icon" href="favicon.ico">
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	<link rel="bookmark" type="image/x-icon" href="favicon.ico">
	<link rel="stylesheet" type="text/css" href="../css/menu.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="css/support.css">
</head>
<body>
<?php include "../includes/header.inc.php";?>
<div class="container support">
	<div class="heitao-logo"></div>
    <form action="search.php" method="get">
    	<div class="search">
    		<input class="text" type="search" name="search">
    		<input class="button" type="submit" value="搜索">
    	</div>
    </form>
    <div class="hot">
    <div class="hot-title">常见问题:</div>
    <div class="hot-content">
		<?php foreach ($help as $key => $value): ?>
		<a href="/support/?s=<?php echo $value['ID']; ?>"><?php echo $value['Title']; ?></a>
		<?php endforeach?>
	</div>
    </div>
</div>
<?php include "../includes/footer.inc.php";?>
</body>
</html>