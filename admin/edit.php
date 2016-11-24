<?php
header("content-type:text/html;charset=utf-8");
require_once $_SERVER['DOCUMENT_ROOT'] . "/common/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-article.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-manage.php";
session_start();
if (!empty($_SESSION['ID'])) {
    if (!empty($_SESSION['Role']) && ($_SESSION['Role'] == 'Admin' || $_SESSION['Role'] == 'Root')) {
        $article = new Article();
        $audit   = $article->LoaderTotal('', '', 'pending');
        if (empty($_GET['s'])) {
            if (!empty($_POST)) {
                if (empty($_POST['Title'])) {
                    $_SESSION['Notice'] = "标题不可为空！";
                }
                if (empty($_SESSION['Notice']) && empty($_POST['Visibility'])) {
                    $_SESSION['Notice'] = "请选择可见性！";
                }
                if (empty($_SESSION['Notice']) && empty($_POST['Tag'])) {
                    $_SESSION['Notice'] = "请选择类别！";
                }
                if (empty($_SESSION['Notice']) && empty($_POST['Body'])) {
                    $_SESSION['Notice'] = "正文不可为空！";
                }
                if (empty($_SESSION['Notice'])) {
                    $manage     = new Manage();
                    $title      = $_POST['Title'];
                    $visibility = $_POST['Visibility'];
                    $tag        = $_POST['Tag'];
                    $body       = $_POST['Body'];
                    $manage->Publish($title, $visibility, $tag, $body);
                }
            }
        } else {
            if (!empty($_GET['s']) && is_numeric($_GET['s'])) {
                $manage = new Manage();
                $id     = $_GET['s'];
                if (!empty($_POST)) {
                    $manage->Update($id);
                }
                $visibility = 'ALL';
                $result     = $manage->Browser($id, $visibility);
                if (empty($result)) {
                    $_SESSION['Notice'] = "该内容不存在！";
                    PageJump("{$_SERVER['PHP_SELF']}");
                }
            }
        }
    } else {
        $_SESSION['Notice'] = "您没有足够权限访问该内容！";
        PageJump("../user/home.php");
    }
} else {
    PageJump("../user/login.php?url={$_SERVER['PHP_SELF']}");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo empty($_GET['s']) ? '支持文档发布' : '支持文档编辑'; ?></title>
	<link rel="icon" type="image/x-icon" href="../favicon.ico">
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">
	<link rel="bookmark" type="image/x-icon" href="../favicon.ico">
    <link rel="stylesheet" type="text/css" href="../css/menu.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <link rel="stylesheet" type="text/css" href="css/manage.css">
    <script src="../ckeditor/ckeditor.js"></script>
	<link rel="stylesheet" href="../ckeditor/css/ckeditor.css">
</head>
<body>
<?php include "../includes/header.inc.php";?>
<div class="container manage">
	<div class="admin-bar">
        <a href="audit.php">机构审核(<?php echo $audit; ?>)</a>
        <a href="article.php">机构管理</a>
        <a class="on" href="manage.php">网站管理</a>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>">其他</a>
    </div>
	<?php SetNotice("2");?>
	<div class="title-bar"><?php echo empty($_GET['s']) ? '支持文档发布' : '支持文档编辑'; ?></div>
	<?php if (!empty($_GET['s'])): ?>
	<form class="surpport-publish" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
		<div class="manage-title">
			<label>标题(必填):<div class="warn">请填写标题</div></label>
			<div><input id="manage-title" type="text" placeholder="在此输入标题" name="Title" value="<?php echo $result['Title']; ?>"></div>
		</div>
		<div class="manage-set">
			<div class="manage-visibility">
				<label>可见性(必选):</label>
				<label><input type="radio" <?php echo $result['Visibility'] == 1 ? 'checked=true' : ''; ?> value="true" name="Visibility">可见</label>
				<label><input type="radio" <?php echo $result['Visibility'] == 1 ? '' : 'checked=true'; ?> value="false" name="Visibility">不可见</label>
			</div>
			<div class="manage-tag">
				<label>类别(必选):</label>
				<select id="tag" name="Tag">
					<option value="0">请选择</option>
					<option value="help">帮助</option>
					<option value="notice">公告</option>
					<option value="other">其他</option>
				</select>
			</div>
			<script type="text/javascript">
				document.getElementById('tag').value='<?php echo $result['Tag']; ?>';
			</script>
		</div>
		<div class="manage-body">
			<label>正文(必填):<span class="warn">请填写正文内容</span></label>
			<textarea id="editor" name="Body"><?php echo $result['Body']; ?></textarea>
			<script>
				CKEDITOR.replace('editor');
			</script>
		</div>
		<div class="manage-publish-button">
			<input type="submit" value="保存">
			<input type="reset" value="取消">
		</div>
	</form>
	<?php else: ?>
	<form class="surpport-publish" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<div class="manage-title">
			<label>标题(必填):<div class="warn">请填写标题</div></label>
			<div><input id="manage-title" type="text" placeholder="在此输入标题" name="Title"></div>
		</div>
		<div class="manage-set">
			<div class="manage-visibility">
				<label>可见性(必选):</label>
				<label><input type="radio" checked="true" value="true" name="Visibility">可见</label>
				<label><input type="radio" value="false" name="Visibility">不可见</label>
			</div>
			<div class="manage-tag">
				<label>类别(必选):</label>
				<select name="Tag">
					<option value="0">请选择</option>
					<option value="help">帮助</option>
					<option value="notice">公告</option>
					<option value="other">其他</option>
				</select>
			</div>
		</div>
		<div class="manage-body">
			<label>正文(必填):<span class="warn">请填写正文内容</span></label>
			<textarea id="editor" name="Body"></textarea>
			<script>
				CKEDITOR.replace('editor');
			</script>
		</div>
		<div class="manage-publish-button">
			<input type="submit" value="发布">
			<input type="reset" value="取消">
		</div>
	</form>
	<?php endif?>
</div>
<?php include "../includes/footer.inc.php";?>
</body>
</html>