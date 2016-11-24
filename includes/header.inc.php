<header class="header">
	<a class="logo" href="/"><img src="/images/logo/logo.png" alt="logo"></a>
	<a class="navbar-toggle" id="NavbarToggle" href="javascript:void(0)">
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</a>
	<ul class="menu" id="Menu">
		<li class="menu-item"><a href="/">首页</a></li>
		<li class="menu-item"><a href="/article/design.php">设计平台</a></li>
		<li class="menu-item"><a href="/about.php">关于我们</a></li>
		<li class="menu-item"><a href="/support/support.php">支持</a></li>
		<li class="account">
			<?php
@session_start();
if (!empty($_SESSION['ID'])) {
    ?>
			<a id="User" class="user" href="/user/home.php?id=<?php echo $_SESSION['ID']; ?>">
				<img src="/user/avatar/<?php echo $_SESSION['Avatar']; ?>">
				<span><?php echo $_SESSION['Name']; ?></span>
			</a>
			<ul class="account-menu">
				<li><a href="/user/home.php?id=<?php echo $_SESSION['ID']; ?>">我的主页</a></li>
				<li><a href="/article/publish.php">发布机构</a></li>
				<?php if (!empty($_SESSION['Role']) && ($_SESSION['Role'] == 'Admin' || $_SESSION['Role'] == 'Root')): ?>
				<li><a href="/admin/index.php">网站管理</a></li>
				<?php endif?>
				<li><a href="/user/safe.php">安全中心</a></li>
				<li><a href="/user/manage.php?id=<?php echo $_SESSION['ID']; ?>">个人设置</a></li>
				<li><a href="/user/logout.php">退出</a></li>
			</ul>
			<?php
} else {
    ?>
			<a href="/user/login.php?url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">登录/注册</a>
			<?php
}
?>
		</li>
	</ul>
</header>