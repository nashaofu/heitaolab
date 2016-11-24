<?php
header("content-type:text/html;charset=utf-8");
require_once $_SERVER['DOCUMENT_ROOT'] . "/common/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-article.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-manage.php";
session_start();
if (!empty($_SESSION['ID'])) {
    if (!empty($_SESSION['Role']) && ($_SESSION['Role'] == 'Admin' || $_SESSION['Role'] == 'Root')) {
        $article     = new Article();
        $audit       = $article->LoaderTotal('', '', 'pending');
        $tag         = 'ALL';
        $visibility  = 'ALL';
        $offset      = 0;
        $length      = 50;
        $CurrentPage = 1;
        if (!empty($_GET['tag'])) {
            $tag = $_GET['tag'];
        }
        if (!empty($_GET['visibility'])) {
            $visibility = $_GET['visibility'];
        }
        if (!empty($_GET['offset'])) {
            $offset      = ($_GET['offset'] - 1) * $length;
            $CurrentPage = $_GET['offset'];
        }
        if (!empty($_GET['length'])) {
            $length = $_GET['length'];
        }
        $manage      = new Manage();
        $TotalRecord = $manage->LoaderTotal($tag, $visibility);
        $TotalPage   = ceil($TotalRecord / $length);
        //当前页面设置
        if ($CurrentPage * $length > $TotalRecord) {
            $CurrentPage = $TotalPage;
        }
        if (ceil($offset / $length) == $CurrentPage) {
            $CurrentPage += 1;
            $TotalPage += 1;
        }
        $result = $manage->Loader($tag, $visibility, $offset, $length);
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
    <title>网站管理</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">
    <link rel="bookmark" type="image/x-icon" href="../favicon.ico">
    <link rel="stylesheet" type="text/css" href="../css/menu.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <link rel="stylesheet" type="text/css" href="css/manage.css">
    <link rel="stylesheet" type="text/css" href="css/pagination.css">
    <script type="text/javascript" src="../js/jquery-2.2.3.min.js"></script>
    <script type="text/javascript" src="js/pagination.js"></script>
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
    <div class="manage-set-bar"><a href="edit.php">添加支持文档</a></div>
    <form class="manage-table search-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <th class="item-tag">分类</th>
                    <th class="item-visibility">状态</th>
                </tr>
                <tr class="item">
                    <td class="item-tag">
                        <select name="tag">
                            <option value="ALL">全部</option>
                            <option value="help">帮助</option>
                            <option value="notice">公告</option>
                            <option value="other">其他</option>
                        </select>
                    </td>
                    <td class="item-visibility">
                        <label><input type="radio" name="visibility" checked="ture" value="ALL">全部</label>
                        <label><input type="radio" name="visibility" value="true">可见</label>
                        <label><input type="radio" name="visibility" value="false">不可见</label>
                    </td>
                </tr>
                <tr class="item">
                    <td class="item-btn" colspan="2">
                        <input type="submit" value="查找">
                        <input type="reset" value="重置">
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <div class="manage-bar">
        <span>共<a href="javascript:void(0)"><?php echo $TotalRecord; ?></a>个机构</span>
        <span>第<?php echo ($offset + 1) . '-' . ($offset + count($result)); ?>个机构</span>
        <span>每页显示<a href="javascript:void(0)"><?php echo $length; ?></a>个结果</span>
    </div>
    <div class="manage-table">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <th class="table-id">ID</th>
                    <th class="table-title">标题</th>
                    <th class="table-visibility">状态</th>
                    <th class="table-tag">类别</th>
                    <th class="table-time">时间</th>
                    <th class="table-edit">操作</th>
                </tr>
                <?php foreach ($result as $key => $value) {
    if ($value['Visibility']) {
        $value['Visibility'] = '可见';
    } else {
        $value['Visibility'] = '不可见';
    }
    if ($value['Tag'] == 'help') {
        $value['Tag'] = '帮助';
    }
    if ($value['Tag'] == 'notice') {
        $value['Tag'] = '公告';
    }
    if ($value['Tag'] == 'other') {
        $value['Tag'] = '其他';
    }
    ?>
                <tr class="item">
                    <td class="table-id"><?php echo $value['ID']; ?></td>
                    <td class="table-title"><a href="/support/?s=<?php echo $value['ID']; ?>" target="_blank"><?php echo $value['Title']; ?></a></td>
                    <td class="table-visibility"><?php echo $value['Visibility']; ?></td>
                    <td class="table-tag"><?php echo $value['Tag']; ?></td>
                    <td class="table-time"><?php echo date('Y-m-d', strtotime($value['Time'])); ?></td>
                    <td class="table-edit"><a class="edit" href="edit.php?s=<?php echo $value['ID']; ?>">编辑</a></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
        <?php if (isset($TotalRecord) && $TotalRecord == 0): ?>
            <div class="noresult"><span class="emoji">:(</span><span>没有符合条件的文档</span></div>
        <?php endif?>
    </div>
    <?php if (!empty($result)): ?>
    <div class="pagination-btns">
        <div class="pagination"></div>
    </div>
    <?php endif?>
<script type="text/javascript">
var article=document.getElementsByClassName('item');
for (var i = 0; i < article.length; i++) {
    if (i%2==1) {
        article[i].setAttribute('style','background-color:#fafafa;');
    }
}
$(".pagination").pagination({
    totalPage:<?php echo $TotalPage; ?>,
    currentPage:<?php echo $CurrentPage; ?>,
    backFn:function(e){
        var url=window.location.href;
        var RegEx=/((\?|&)offset=\d{1,})+/;
        if (RegEx.test(url)) {
            url=url.replace(RegEx,'?offset='+e);
            window.location.href=url.replace(/(&offset=\d{1,})+/,'&offset='+e);
        }
        else{
            window.location.href+='?offset='+e;
        }
    }
});
</script>
</div>
</div>
<?php include "../includes/footer.inc.php";?>
</body>
</html>