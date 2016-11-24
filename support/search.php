<?php
header("content-type:text/html;charset=utf-8");
require_once $_SERVER['DOCUMENT_ROOT'] . "/common/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-manage.php";
$search = '';
$result = array();
if (!empty($_GET['search'])) {
    $search      = trim($_GET['search']);
    $tag         = 'help';
    $visibility  = 'true';
    $offset      = 0;
    $length      = 20;
    $CurrentPage = 1;
    $TotalPage   = 1;
    if (!empty($_GET['offset']) && is_numeric($_GET['offset'])) {
        $offset      = (trim($_GET['offset']) - 1) * $length;
        $CurrentPage = trim($_GET['offset']);
    }
    $manage = new Manage();
    //总记录条数
    $TotalRecord = $manage->SearchTotal($search);
    //总页数设置
    $TotalPage = ceil($TotalRecord / $length);
    $result    = $manage->Search($search, $tag, $visibility, $offset, $length);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $search; ?>-支持搜索</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link rel="bookmark" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" type="text/css" href="../css/menu.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="css/support.css">
    <link rel="stylesheet" type="text/css" href="../article/css/pagination.css">
    <script type="text/javascript" src="../js/jquery-2.2.3.min.js"></script>
    <script type="text/javascript" src="../article/js/pagination.js"></script>
</head>
<body>
<?php include "../includes/header.inc.php";?>
<div class="container search-result">
    <form id="search" action="search.php" method="get">
        <img class="search-logo-img" src="../images/logo/logo.gif">
        <div class="search">
            <input id="keyword" class="text" type="search" name="search" value="<?php echo $search; ?>">
            <input class="button" type="submit" value="搜索">
        </div>
    </form>
    <div class="result-block">
        <?php if (!empty($result)): ?>
        <div class="result-total">为您找到相关结果<?php echo $TotalRecord; ?>个</div>
        <table class="result-list" border="0" cellpadding="0" cellspacing="0">
            <tbody>
                <?php foreach ($result as $key => $value): ?>
                <?php
$value['Title'] = str_ireplace($search, '<span class="keyword">' . $search . '</span>', $value['Title']);
?>
                <tr>
                    <td colspan="2">
                        <div class="result-title">
                            <a href="/support/?s=<?php echo $value['ID']; ?>"><?php echo $value['Title']; ?></a>
                        </div>
                    </td>
                </tr>
                <tr class="table-body">
                    <td colspan="2"><?php echo $value['Body']; ?></td>

                </tr>
                <tr class="table-footer">
                    <td colspan="2">
                        <div>
                            <a href="/support/?s=<?php echo $value['ID']; ?>"><?php echo $_SERVER['HTTP_HOST']; ?>/support/?s=<?php echo $value['ID']; ?></a>
                            <a  class="hitcount" href="javascript:void(0)">点击量[<?php echo $value['HitCount']; ?>]</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach?>
            </tbody>
        </table>
        <div class="pagination-btns">
            <div class="pagination"></div>
        </div>
        <script type="text/javascript">
        $(".pagination").pagination({
            totalPage:<?php echo $TotalPage; ?>,
            currentPage:<?php echo $CurrentPage; ?>,
            backFn:function(e){
                var url=window.location.href;
                var RegEx=/(&offset=\d{1,})/;
                if (RegEx.test(url)) {
                    window.location.href=url.replace(RegEx,'&offset='+e);
                }
                else{
                    window.location.href+='&offset='+e;
                }
            }
        });
        </script>
        <?php else: ?>
        <div class="noresult"><span class="emoji">:(</span><span>没有搜索到结果</span></div>
        <?php endif?>
    </div>
</div>
<script type="text/javascript">
var search=document.getElementById('search');
var keyword=document.getElementById('keyword');
var blank= /(^\s*)|(\s*$)/g;
search.onsubmit=function(){
    keyword.value=keyword.value.replace(blank,'');
    if (keyword.value=='') {
        return false;
    }
}
</script>
<?php include "../includes/footer.inc.php";?>
</body>
</html>