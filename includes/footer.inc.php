<footer class="footer">
	<div>
		<div>
			<a class="drop-button" href="javascript:void(0)">站内导航</a>
			<ul class="footer-ul">
				<li><a href="/article/design.php">设计平台</a></li>
				<li><a href="/user/safe.php">安全中心</a></li>
				<li><a href="/support/support.php">支持文档</a></li>
			</ul>
		</div>
		<div>
			<a class="drop-button" href="javascript:void(0)">友情链接</a>
			<ul class="footer-ul">
				<li><a href="http://www.bootcss.com/">bootstrap中文网</a></li>
				<li><a href="http://study.163.com">网易云课堂</a></li>
				<li><a href="http://www.w3school.com.cn/">w3shool</a></li>
			</ul>
		</div>
		<div>
			<a class="drop-button" href="javascript:void(0)">热门下载</a>
			<ul class="footer-ul">
				<li><a href="javascript:void(0)">w3shool手册</a></li>
				<li><a href="javascript:void(0)">CSS手册</a></li>
				<li><a href="javascript:void(0)">PHP手册</a></li>
			</ul>
		</div>
		<div>
			<a class="drop-button" href="javascript:void(0)">常见问题</a>
			<ul class="footer-ul">
				<li><a href="/support/?s=1">如何发布机构</a></li>
				<li><a href="/support/?s=2">如何注册</a></li>
				<li><a href="/support/?s=3">找回密码</a></li>
			</ul>
		</div>
	</div>
    <div>
		<a href="/about.php#2">联系我们</a>
		<a href="/about.php#3">隐私声明</a>
		<a href="/about.php#4">加入我们</a>
		<a href="/about.php">关于</a>
    </div>
    <div>
<?php
function auto_copyright()
{
    $thisYear = date('Y');
    echo "&copy;{$thisYear} 黑桃LAB";
}
?>
		<a href="http://www.miitbeian.gov.cn/">渝ICP备15002592号</a>
		<a href="javascript:void(0)"><?php auto_copyright();?></a>
    </div>
</footer>
<script type="text/javascript" src="/js/menu.js"></script>