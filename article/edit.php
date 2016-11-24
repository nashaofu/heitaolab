<?php
header("content-type:text/html;charset=utf-8");
require_once $_SERVER['DOCUMENT_ROOT'] . "/common/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-article.php";
session_start();
if (!empty($_SESSION['ID'])) {
    $article = new Article();
    if (!empty($_GET['a']) && is_numeric($_GET['a'])) {
        $result = $article->Browse($_GET['a'], 'ALL');
        if (empty($result) && (!empty($result) && $result['Publisher']['ID'] != $_SESSION['ID'])) {
            PageJump("../user/home.php");
        }
        if (!empty($_POST)) {
            if (!empty($_GET['a']) && is_numeric($_GET['a'])) {
                $article->Update($_GET['a']);
            }
        }
    } else {
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
	<title>编辑机构</title>
	<link rel="icon" type="image/x-icon" href="../favicon.ico">
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">
	<link rel="bookmark" type="image/x-icon" href="../favicon.ico">
    <link rel="stylesheet" type="text/css" href="../css/menu.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="css/article.css">
    <script src="../ckeditor/ckeditor.js"></script>
	<link rel="stylesheet" href="../ckeditor/css/ckeditor.css">
</head>
<body class="edit">
<?php include "../includes/header.inc.php";?>
<div class="container publish">
	<h1 class="edit-title">编辑机构</h1>
	<?php SetNotice("2");?>
	<form id="publish-form" class="article-publish" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
		<div class="article-title">
			<label>标题:(必填)<span class="warn">请填写标题</span></label>
			<input id="article-title" type="text" placeholder="在此输入标题" value="<?php echo $result['Title']; ?>" name="Title">
		</div>
		<div id="article-input" class="article-category">
			<label>输入运动:(必填)<span class="warn">至少选择一个选项</span></label>
			<div>
				<label><input type="checkbox" name="Input[]" value="R">单向转动(R)</label>
	            <label><input type="checkbox" name="Input[]" value="M">往复移动(M)</label>
	            <label><input type="checkbox" name="Input[]" value="G">导向运动(G)</label>
            </div>
		</div>
		<div id="article-output" class="article-category">
			<label>输出运动:(必填)<span class="warn">至少选择一个选项</span></label>
			<div>
				<table border="0">
					<tbody>
						<tr>
							<th scope="row"><label>转动(Ri)：</label></th>
							<td>
								<label><input type="checkbox" name="Output[]" value="R1">单向转动(R1)</label>
								<label><input type="checkbox" name="Output[]" value="R2">单向匀速转动(R2)</label>
								<label><input type="checkbox" name="Output[]" value="R3">单向间歇转动(R3)</label>
								<label><input type="checkbox" name="Output[]" value="R4">带有波动的单向转动(R4)</label>
								<label><input type="checkbox" name="Output[]" value="R5">往复转动(R5)</label>
								<label><input type="checkbox" name="Output[]" value="R6">往复间歇转动(R6)</label>
								<label><input type="checkbox" name="Output[]" value="R7">带有波动的往复转动(R7)</label>
							</td>
						</tr>
						<tr>
							<th colspan="2"><hr width="100%" size="1" color="#777"></th>
						</tr>
						<tr>
							<th scope="row"><label>移动(Mj)：</label></th>
							<td>
								<label><input type="checkbox" name="Output[]" value="M1">单向直线移动(M1)</label>
	            				<label><input type="checkbox" name="Output[]" value="M2">往复直线移动(M2)</label>
	            				<label><input type="checkbox" name="Output[]" value="M3">往复间歇移动(M3)</label>
	            				<label><input type="checkbox" name="Output[]" value="M4">带有波动的往复移动(M4)</label>
							</td>
						</tr>
						<tr>
							<th colspan="2"><hr width="100%" size="1" color="#777"></th>
						</tr>
						<tr>
							<th scope="row"><label>导向运动(Gk)：</label></th>
							<td>
								<label><input type="checkbox" name="Output[]" value="G1">点在圆上(G1)</label>
								<label><input type="checkbox" name="Output[]" value="G2">点在直线上(G2)</label>
								<label><input type="checkbox" name="Output[]" value="G3">点在一般曲线上(G3)</label>
								<label><input type="checkbox" name="Output[]" value="G4">刚体平移(G4)</label>
								<label><input type="checkbox" name="Output[]" value="G5">刚体转动(G5)</label>
								<label><input type="checkbox" name="Output[]" value="G6">刚体做一般运动(G6)</label>
								<label><input type="checkbox" name="Output[]" value="G7">刚体定位(G7)</label>
							</td>
						</tr>
					</tbody>
				</table>
            </div>
		</div>
<script type="text/javascript">
var articleinput=document.getElementById('article-input').getElementsByTagName('input');
var articleoutput=document.getElementById('article-output').getElementsByTagName('input');
<?php
$result['Input']  = explode(',', $result['Input']);
$result['Output'] = explode(',', $result['Output']);
$inputs           = '';
foreach ($result['Input'] as $key => $value) {
    if ($key < count($result['Input']) - 1) {
        $inputs .= '"' . $value . '"' . ',';
    } else {
        $inputs .= '"' . $value . '"';
    }
}
echo "var inputs=[{$inputs}];";
$outputs = '';
foreach ($result['Output'] as $key => $value) {
    if ($key < count($result['Output']) - 1) {
        $outputs .= '"' . $value . '"' . ',';
    } else {
        $outputs .= '"' . $value . '"';
    }
}
echo "var outputs=[{$outputs}];";
?>
for (var i = 0; i < articleinput.length; i++) {
	for (var index = 0; index < inputs.length; index++) {
		if(articleinput[i].value==inputs[index]){
			articleinput[i].checked=true;
		}
	}
}
for (var i = 0; i < articleoutput.length; i++) {
	for (var index = 0; index < outputs.length; index++) {
		if(articleoutput[i].value==outputs[index]){
			articleoutput[i].checked=true;
		}
	}
}
</script>
		<div class="article-summary">
			<label>简介:(必填)<span class="warn">请填写简介</span></label>
			<textarea id="article-summary" placeholder="请填写简介，长度不得超过400字！" maxlength="400" name="Summary"><?php echo $result['Summary']; ?></textarea>
		</div>
		<div class="article-example">
			<label>实例:(可选)<a id="addexample" href="javascript:void(0)">添加实例</a></label>
			<div id='examples-block'>
				<div id="examples"></div>
			</div>
			<div id="addbox-mask"></div>
			<div id="addbox">
				<div class="addbox-title-bar"><div class="tit">添加实例</div><a id="close" href="javascript:void(0)" title="关闭">X</a></div>
				<div id="btn-bar" class="btn-bar"><a href="javascript:void(0)">常规</a><a href="javascript:void(0)">上传</a></div>
				<div class="section">
					<div>
						<p>实例名称：</p>
						<p><input id="example-name" maxlength="30" type="text" placeholder="最长30个字符"></p>
					</div>
					<div>
						<p>URL:</p>
						<p><input maxlength="256" id="example-url" type="text" placeholder="最长256个字符"></p>
					</div>
				</div>
				<div class="section">
					<div>上传到服务器</div>
					<iframe id="iframe" class="iframe" src="dialog.html" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" name="targetFrame"></iframe>
				</div>
				<div class="footer-bar">
					<div><a id="ok" class="footer-bar-btn" href="javascript:void(0)">确定</a><a id="cancel" class="footer-bar-btn" href="javascript:void(0)">取消</a>
					</div>
				</div>
			</div>
			<script type="text/javascript" src="js/upload.js"></script>
		</div>
<script type="text/javascript">
<?php
foreach ($result['Example'] as $key => $value) {
    echo "AddExample('{$value['name']}', '{$value['url']}', false);";
}
?>
</script>
		<div class="article-body">
			<label>正文:(必填)<span class="warn">请填写正文内容</span></label>
			<textarea id="editor" name="Body"><?php echo $result['Body']; ?></textarea>
			<script>
				CKEDITOR.replace('editor');
			</script>
		</div>
		<div class="article-publish-button">
			<input type="submit" value="修改">
			<input type="reset" value="取消">
		</div>
	</form>
</div>
<?php include "../includes/footer.inc.php";?>
<script type="text/javascript" src="js/check.js"></script>
</body>
</html>