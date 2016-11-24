<?php
header("content-type:text/html;charset=utf-8");
require_once $_SERVER['DOCUMENT_ROOT'] . "/common/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-user.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-article.php";
session_start();
if (!empty($_SESSION['ID'])) {
    if (!empty($_GET['id']) && $_GET['id'] == $_SESSION['ID']) {
        $Age     = floor(date("Ymd", time()) / 10000 - date("Ymd", strtotime($_SESSION['Birthday'])) / 10000);
        $article = new Article();
        $My      = $article->MyArticle($_SESSION['ID']);
    } else {
        PageJump("{$_SERVER['PHP_SELF']}?id={$_SESSION['ID']}");
    }
} else {
    PageJump("login.php?url={$_SERVER['PHP_SELF']}");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>我的主页</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">
	<link rel="bookmark" type="image/x-icon" href="../favicon.ico">
    <link rel="stylesheet" type="text/css" href="../css/menu.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="css/user.css">
</head>
<body>
<?php include "../includes/header.inc.php";?>
<div class="container home">
	<div class="home-container">
		<div class="home-avatar">
			<img class="home-avatar-img" src="/user/avatar/<?php echo $_SESSION['Avatar']; ?>" alt="头像">
		</div>
		<div class="home-resume">
			<div class="name-bar">
				<span class="Name"><?php echo $_SESSION['Name']; ?></span>
				<span class="LV"><?php echo $_SESSION['LV']; ?></span>
			</div>
			<div class="data-bar">
				<a href="#"><div><?php echo $_SESSION['Points']; ?></div><div>积分</div></a>
				<a href="#"><div><?php echo $_SESSION['Focus-Size']; ?></div><div>关注</div></a>
				<a href="#"><div><?php echo $_SESSION['Fans-Size']; ?></div><div>粉丝</div></a>
			</div>
			<div class="introduction-bar">
				<span>个人介绍：<?php echo $_SESSION['Introduction']; ?></span>
            </div>
            <div class="address-bar">
            	<span>所在地区：<?php echo explode(',', $_SESSION['Area'])[0]; ?></span>
            </div>
            <div class="gender-bar">
            	<span>性别：<?php echo $_SESSION['Gender']; ?></span>
            </div>
            <div class="birthday-bar">
            	<span>年龄：<?php echo $Age; ?></span>
            </div>
		</div>
	</div>
	<div class="home-container">
		<h2>我的等级</h2>
		<div class="home-LV">
			<h3>当前等级：<span><?php echo $_SESSION['LV']; ?></span></h3>
			<h3>经验值：<span><?php echo $_SESSION['XP']; ?></span><em>/</em><span>8</span></h3>
			<h3>当前等级特权：</h3>
			<ul>
				<li>黑名单上限20</li>
				<li>每日发帖量增加10</li>
				<li>随机获得价值400~1000积分的积分券</li>
			</ul>
		</div>
	</div>
	<div class="home-container">
		<h2>我的机构<span>(<?php echo count($My); ?>)</span></h2>
		<div class="article">
			<div class="table">
				<div class="article-header">
					<div class="table-id"><div>序号</div></div>
					<div class="table-name">机构名称</div>
					<div class="table-status">状态</div>
					<div class="table-time">发布时间</div>
					<div class="table-edit">编辑</div>
				</div>
				<?php
foreach ($My as $key => $value) {
    if ($value['Status'] == 'draft') {
        $value['Status'] = '草稿';
    }
    if ($value['Status'] == 'nopass') {
        $value['Status'] = '未通过';
    }
    if ($value['Status'] == 'pending') {
        $value['Status'] = '审核中';
    }
    if ($value['Status'] == 'undershelf') {
        $value['Status'] = '下架';
    }
    if ($value['Status'] == 'publish') {
        $value['Status'] = '公开';
    }
    ?>
	            <div class="item">
                	<div class="article-id"><div><?php echo $key + 1; ?></div></div>
                    <div class="article-title"><a href="/article/?a=<?php echo $value['ID']; ?>"><?php echo $value['Title']; ?></a></div>
                    <div class="article-status"><?php echo $value['Status']; ?></div>
                    <div class="article-time"><?php echo date('Y-m-d', strtotime($value['Time'])); ?></div>
                    <div class="article-edit"><a href="/article/edit.php?a=<?php echo $value['ID']; ?>">编辑</a></div>
	            </div>
	            <?php }?>
	        </div>
		</div>
	</div>
	<script type="text/javascript">
	var article=document.getElementsByClassName('item');
	for (var i = 0; i < article.length; i++) {
		if (i%2==1) {
			article[i].setAttribute('style','background-color:#fafafa;');
		}
	}
	</script>
</div>
<?php include "../includes/footer.inc.php";?>
</body>
</html>
