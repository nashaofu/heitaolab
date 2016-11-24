<?php
header("content-type:text/html;charset=utf-8");
require_once $_SERVER['DOCUMENT_ROOT'] . "/common/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-article.php";
session_start();
if (!empty($_SESSION['ID'])) {
    if (!empty($_SESSION['Role']) && ($_SESSION['Role'] == 'Admin' || $_SESSION['Role'] == 'Root')) {
        $article = new Article();
        //设置默认值
        $filter      = 'pending';
        $offset      = 0;
        $length      = 50;
        $CurrentPage = 1;
        if (!empty($_GET['length']) && is_numeric($_GET['length'])) {
            $length = $_GET['length'];
        }
        if (!empty($_GET['offset']) && is_numeric($_GET['offset'])) {
            $offset      = ($_GET['offset'] - 1) * $length;
            $CurrentPage = $_GET['offset'];
        }
        //总记录条数
        $TotalRecord = $article->LoaderTotal('', '', $filter);
        //总页数设置
        $TotalPage = ceil($TotalRecord / $length);
        //当前页面设置
        if ($CurrentPage * $length > $TotalRecord) {
            $CurrentPage = $TotalPage;
        }
        if (ceil($offset / $length) == $CurrentPage) {
            $CurrentPage += 1;
            $TotalPage += 1;
        }
        $audit = $article->Loader('', '', $filter, $offset, $length, 'ID', 'ASC');
    } else {
        PageJump("../user/home.php");
        $_SESSION['Notice'] = "您没有足够权限访问该内容！";
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
    <title>机构审核</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">
    <link rel="bookmark" type="image/x-icon" href="../favicon.ico">
    <link rel="stylesheet" type="text/css" href="../css/menu.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="css/audit.css">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <script type="text/javascript" src="../js/jquery-2.2.3.min.js"></script>
    <script type="text/javascript" src="../js/ajax.js"></script>
    <link rel="stylesheet" type="text/css" href="css/pagination.css">
    <script type="text/javascript" src="js/pagination.js"></script>
</head>
<body>
<?php include "../includes/header.inc.php";?>
<div class="container audit" id="container">
    <div class="admin-bar">
        <a class="on" href="audit.php">机构审核(<?php echo count($audit); ?>)</a>
        <a href="article.php">机构管理</a>
        <a href="manage.php">网站管理</a>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>">其他</a>
    </div>
    <div class="set-bar">
        <span>共有<a href="javascript:void(0)"><?php echo $TotalRecord; ?></a>个机构待审核</span>
        <span>每页显示<a href="javascript:void(0)">50</a>个结果</span>
    </div>
    <div class="article">
        <div class="table">
            <div class="article-header">
                <div class="table-id"><div>机构ID</div></div>
                <div class="table-name">机构名称</div>
                <div class="table-time">发布时间</div>
                <div class="table-audit">操作</div>
            </div>
            <?php foreach ($audit as $key => $value) {?>
            <div class="item">
                <div class="article-id"><div><?php echo $value['ID']; ?></div></div>
                <div class="article-title"><?php echo $value['Title']; ?></div>
                <div class="article-time"><?php echo date('Y-m-d', strtotime($value['Time'])); ?></div>
                <div class="article-audit">
                    <a class="pass" href="javascript:void(0)" data-id="<?php echo $value['ID']; ?>">通过</a>
                    <a class="deny" href="javascript:void(0)" data-id="<?php echo $value['ID']; ?>">拒绝</a>
                    <a href="javascript:void(0)" onclick="view('<?php echo $value['ID']; ?>','<?php echo $value['Title']; ?>')">查看</a>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
    <?php if (isset($TotalRecord) && $TotalRecord != 0): ?>
    <div class="pagination-btns">
        <div class="pagination"></div>
    </div>
    <?php endif?>
</div>
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
<?php include "../includes/footer.inc.php";?>
<script type="text/javascript" src="js/mask.js"></script>
<script type="text/javascript">
function view(src, title) {
    src = '/admin/view.php?a=' + src;
    $('#container').mask(src, title);
}
$('.pass').click(function() {
    pass($(this).data('id'), $(this));
})
$('.deny').click(function() {
    deny($(this).data('id'), $(this));
})

function pass(id, obj) {
    ajax('/ajax/audit.php', 'POST', {
        aid: id,
        type: 'PASS'
    }, function(e) {
        if (e === '设置成功！') {
            obj.parent().parent('.item').remove();
        }
        alert(e);
    })
}

function deny(id, obj) {
    ajax('/ajax/audit.php', 'POST', {
        aid: id,
        type: 'DENY'
    }, function(e) {
        if (e === '设置成功！') {
            obj.parent().parent('.item').remove();
        }
        alert(e);
    })
}
</script>
</body>
</html>