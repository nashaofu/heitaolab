<?php
header("content-type:text/html;charset=utf-8");
require_once $_SERVER['DOCUMENT_ROOT'] . "/common/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-article.php";
session_start();
if (!empty($_SESSION['ID'])) {
    if (!empty($_SESSION['Role']) && ($_SESSION['Role'] == 'Admin' || $_SESSION['Role'] == 'Root')) {
        //设置默认值
        $id          = '';
        $title       = '';
        $input       = '';
        $output      = '';
        $filter      = 'ALL';
        $offset      = 0;
        $length      = 50;
        $CurrentPage = 1;
        if (!empty($_GET['id'])) {
            $id = trim($_GET['id']);
        }
        if (!empty($_GET['title'])) {
            $title = trim($_GET['title']);
        }
        if (!empty($_GET['input'])) {
            if ($_GET['input'] == 'ALL') {
                $input = '';
            } else {
                $input = $_GET['input'];
            }
        }
        if (!empty($_GET['output'])) {
            if ($_GET['output'] == 'ALL') {
                $output = '';
            } else {
                $output = $_GET['output'];
            }
        }
        if (!empty($_GET['filter'])) {
            $filter = $_GET['filter'];
        }
        if (!empty($_GET['length']) && is_numeric($_GET['length'])) {
            $length = $_GET['length'];
        }
        if (!empty($_GET['offset']) && is_numeric($_GET['offset'])) {
            $offset      = ($_GET['offset'] - 1) * $length;
            $CurrentPage = $_GET['offset'];
        }
        $article = new Article();
        //总记录条数
        $TotalRecord = $article->SearchTotal($id, $title, $input, $output, $filter);
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
        $result  = $article->Search($id, $title, $input, $output, $filter, $offset, $length);
        $audit   = $article->LoaderTotal('', '', 'pending');
        $inputV  = $input;
        $outputV = $output;
        if ($inputV == '') {
            $inputV = 'ALL';
        }
        if ($outputV == '') {
            $outputV = 'ALL';
        }
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
    <title>机构管理</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">
    <link rel="bookmark" type="image/x-icon" href="../favicon.ico">
    <link rel="stylesheet" type="text/css" href="../css/menu.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="css/audit.css">
    <link rel="stylesheet" type="text/css" href="css/article.css">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <script type="text/javascript" src="../js/jquery-2.2.3.min.js"></script>
    <script type="text/javascript" src="../js/ajax.js"></script>
    <link rel="stylesheet" type="text/css" href="css/pagination.css">
    <script type="text/javascript" src="js/pagination.js"></script>
</head>
<body>
<?php include "../includes/header.inc.php";?>
<div class="container manage audit" id="container">
    <div class="admin-bar">
        <a href="audit.php">机构审核(<?php echo $audit; ?>)</a>
        <a class="on" href="article.php">机构管理</a>
        <a href="manage.php">网站管理</a>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>">其他</a>
    </div>
    <form class="search-form">
        <div class="article-search">
            <div class="search-table">
                <div class="search-header">
                    <div class="search-id"><div>机构ID</div></div>
                    <div class="search-title">机构名称</div>
                    <div class="search-status">机构状态</div>
                </div>
                <div class="item">
                    <div class="search-id"><div><input type="search" placeholder="机构ID(数字)" name="id" value="<?php echo $id; ?>"></div></div>
                    <div class="search-title"><input type="search" placeholder="请输入机构名称(支持模糊搜索)" name="title" value="<?php echo $title; ?>"></div>
                    <div class="search-status">
                        <select id="filter" name="filter">
                            <option value="ALL">全部</option>
                            <option value="draft">草稿</option>
                            <option value="pending">审核中</option>
                            <option value="publish">已发布</option>
                        </select>
                    </div>
                </div>
                <div class="item search-tag">
                    <div class="column input">
                        <div class="item-name">输入运动</div>
                        <div class="item-html">
                            <select id="input" name="input">
                                <option value="ALL">全部</option>
                                <option value="R">单向转动(R)</option>
                                <option value="M">往复移动(M)</option>
                                <option value="G">导向运动(G)</option>
                            </select>
                        </div>
                    </div>
                    <div class="column output">
                        <div class="item-name">输出运动</div>
                        <div class="item-html">
                            <select id="output" name="output">
                                <option value="ALL">全部</option>
                                <option value="R">转动(R)</option>
                                <option value="M">移动(M)</option>
                                <option value="G">导向(G)</option>
                                <option value="R1">单向转动(R1)</option>
                                <option value="R2">单向匀速转动(R2)</option>
                                <option value="R3">单向间歇转动(R3)</option>
                                <option value="R4">带有波动的单向转动(R4)</option>
                                <option value="R5">往复转动(R5)</option>
                                <option value="R6">往复间歇转动(R6)</option>
                                <option value="R7">带有波动的往复转动(R7)</option>
                                <option value="M1">单向直线移动(M1)</option>
                                <option value="M2">往复直线移动(M2)</option>
                                <option value="M3">往复间歇移动(M3)</option>
                                <option value="M4">带有波动的往复移动(M4)</option>
                                <option value="G1">点在圆上(G1)</option>
                                <option value="G2">点在直线上(G2)</option>
                                <option value="G3">点在一般曲线上(G3)</option>
                                <option value="G4">刚体平移(G4)</option>
                                <option value="G5">刚体转动(G5)</option>
                                <option value="G6">刚体做一般运动(G6)</option>
                                <option value="G7">刚体定位(G7)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="item btn">
                    <input type="submit" value="查找">
                    <input type="reset" value="重置">
                </div>
            </div>
        </div>
        <script type="text/javascript">
        document.getElementById('filter').value='<?php echo $filter; ?>';
        document.getElementById('input').value='<?php echo $inputV; ?>';
        document.getElementById('output').value='<?php echo $outputV; ?>';
        </script>
    </form>
    <div class="set-bar">
        <span>共<a href="javascript:void(0)"><?php echo $TotalRecord; ?></a>个机构</span>
        <span>第<?php echo ($offset + 1) . '-' . ($offset + count($result)); ?>个机构</span>
        <span>每页显示<a href="javascript:void(0)"><?php echo $length; ?></a>个结果</span>
    </div>
    <div class="article">
        <div class="table">
            <div class="article-header">
                <div class="table-id"><div>机构ID</div></div>
                <div class="table-name">机构名称</div>
                <div class="table-status">状态</div>
                <div class="table-time">发布时间</div>
                <div class="table-audit">操作</div>
            </div>
            <?php foreach ($result as $key => $value) {
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
            <div class="item article-item">
                <div class="article-id"><div><?php echo $value['ID']; ?></div></div>
                <div class="article-title"><a href="javascript:void(0)" onclick="view('<?php echo $value['ID']; ?>','<?php echo $value['Title']; ?>')"><?php echo $value['Title']; ?></a></div>
                <div class="article-status" data-status="<?php echo $value['Status']; ?>"><?php echo $value['Status']; ?></div>
                <div class="article-time"><?php echo date('Y-m-d', strtotime($value['Time'])); ?></div>
                <div class="article-audit article-set">
                    <a class="onshelf" href="javascript:void(0)" data-id="<?php echo $value['ID']; ?>">上架</a>
                    <a class="undershelf" href="javascript:void(0)" data-id="<?php echo $value['ID']; ?>">下架</a>
                    <a class="carousel" href="javascript:void(0)" data-id="<?php echo $value['ID']; ?>">设为轮播</a>

                </div>
            </div>
            <?php }?>
        </div>
<?php if (isset($TotalRecord) && $TotalRecord == 0): ?>
            <div class="noresult"><span class="emoji">:(</span><span>没有符合条件的机构</span></div>
<?php endif?>
    </div>
<?php if (isset($TotalRecord) && $TotalRecord != 0): ?>
    <div class="pagination-btns">
        <div class="pagination"></div>
    </div>
<?php endif?>
</div>
<script type="text/javascript">
var article=document.getElementsByClassName('article-item');
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
        var RegEx1=/(&offset=\d{1,})+/;
        var RegEx2=/(\?offset=\d{1,})+/;
        if (RegEx1.test(url)) {
            url=url.replace(RegEx1,'&offset='+e);
            window.location.href=url;
        }
        else if (RegEx2.test(url)) {
            url=url.replace(RegEx2,'?offset='+e);
            window.location.href=url;
        }
        else{
            window.location.href+='?offset='+e;
        }
    }
});
</script>
<?php include "../includes/footer.inc.php";?>
<script type="text/javascript" src="js/mask.js"></script>
<script type="text/javascript" src="js/upload.js"></script>
<script type="text/javascript">
$('.carousel').click(function(){
    $('#container').upload('dialog.php?aid='+$(this).data('id'),'设置首页轮播');
})
function view(src, title) {
    src = '/admin/view.php?a=' + src;
    $('#container').mask(src, title);
}
$('.onshelf').click(function() {
    var status = $(this).parent().parent().find('.article-status');
    if (status.data('status') === '下架') {
        onshelf($(this).data('id'), status);
    } else if (status.data('status') === '公开') {
        alert('该机构已经处于在架状态了！');
    } else {
        alert('该机构未通过审核,不可设为上架！');
    }
})
$('.undershelf').click(function() {
    var status = $(this).parent().parent().find('.article-status');
    if (status.data('status') === '公开') {
        undershelf($(this).data('id'), status);
    } else if (status.data('status') === '下架') {
        alert('该机构已经处于下架状态了！');
    } else {
        alert('该机构没有上架！');
    }
})

function onshelf(id, obj) {
    ajax('/ajax/audit.php', 'POST', {
        aid: id,
        type: 'ONSHELF'
    }, function(e) {
        if (e === '设置成功！') {
            obj.data('status', '公开');
            obj.text('公开');
            alert('机构已成功上架！');
        }
    })
}

function undershelf(id, obj) {
    ajax('/ajax/audit.php', 'POST', {
        aid: id,
        type: 'UNDERSHELF'
    }, function(e) {
        if (e === '设置成功！') {
            obj.data('status', '下架');
            obj.text('下架');
            alert('机构已成功下架！');
        }
    })
}
</script>
</body>
</html>