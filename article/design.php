<?php
header("content-type:text/html;charset=utf-8");
require_once $_SERVER['DOCUMENT_ROOT'] . "/common/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-article.php";
session_start();
$result = array();
if (!empty($_GET)) {
    if (!empty($_GET['Input']) && !empty($_GET['Output'])) {
        $article = new Article();
        $input   = $_GET['Input'];
        $output  = $_GET['Output'];
        //设置默认值
        $filter      = 'publish';
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
        $TotalRecord = $article->LoaderTotal($input, $output, $filter);
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
        $result = $article->Loader($input, $output, $filter, $offset, $length);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>设计平台</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">
    <link rel="bookmark" type="image/x-icon" href="../favicon.ico">
    <link rel="stylesheet" type="text/css" href="../css/menu.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="css/article.css">
    <link rel="stylesheet" type="text/css" href="css/mask.css">
    <link rel="stylesheet" type="text/css" href="css/pagination.css">
    <script type="text/javascript" src="../js/jquery-2.2.3.min.js"></script>
    <script type="text/javascript" src="js/pagination.js"></script>
</head>
<body>
<?php include "../includes/header.inc.php";?>
<div class="container design">
    <h1 class="design-title">设计平台</h1>
    <?php SetNotice("2");?>
    <form id="design-form" style="display: <?php echo empty($result) ? 'block' : 'none'; ?>" class="design-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <div id="input-box" class="design-category">
            <label>输入运动:<span class="warn">至少选择一个选项</span></label>
            <div>
                <label><input type="checkbox" name="Input[]" value="R">单向转动(R)</label>
                <label><input type="checkbox" name="Input[]" value="M">往复移动(M)</label>
                <label><input type="checkbox" name="Input[]" value="G">导向运动(G)</label>
            </div>
        </div>
        <div id="output-box" class="design-category">
            <label>输出运动:<span class="warn">至少选择一个选项</span></label>
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
<?php if (!empty($_GET['Input']) && !empty($_GET['Output'])): ?>
var articleinput=document.getElementById('input-box').getElementsByTagName('input');
<?php
$inputs = '';
foreach ($_GET['Input'] as $key => $value) {
    if ($key < count($_GET['Input']) - 1) {
        $inputs .= '"' . $value . '"' . ',';
    } else {
        $inputs .= '"' . $value . '"';
    }
}
echo "var inputs=[{$inputs}];";
?>
for (var i = 0; i < articleinput.length; i++) {
    for (var index = 0; index < inputs.length; index++) {
        if(articleinput[i].value==inputs[index]){
            articleinput[i].checked=true;
        }
    }
}
<?php endif?>
<?php if (!empty($_GET['Input']) && !empty($_GET['Output'])): ?>
var articleoutput=document.getElementById('output-box').getElementsByTagName('input');
<?php
$outputs = '';
foreach ($_GET['Output'] as $key => $value) {
    if ($key < count($_GET['Output']) - 1) {
        $outputs .= '"' . $value . '"' . ',';
    } else {
        $outputs .= '"' . $value . '"';
    }
}
echo "var outputs=[{$outputs}];";
?>
for (var i = 0; i < articleoutput.length; i++) {
    for (var index = 0; index < outputs.length; index++) {
        if(articleoutput[i].value==outputs[index]){
            articleoutput[i].checked=true;
        }
    }
}
<?php endif?>
</script>
        <div class="design-form-button">
            <input type="submit" value="开始设计"><input type="reset" value="重置要求">
        </div>
    </form>
    <?php
if (isset($TotalRecord) && $TotalRecord == 0) {
    ?>
    <div class="noresult"><span class="emoji">:(</span><span>没有搜索到结果</span></div>
    <?php
}
?>
    <div class="design-result">
<?php
foreach ($result as $key => $value) {
    if ($key == 0) {
        ?>
        <div class="result-header"><h2 class="result-tit">检索结果</h2><a id="toggle-btn" href="javascript:void(0)">显示面板</a></div>
        <script type="text/javascript">
        var designform = document.getElementById('design-form');
        var togglebtn=document.getElementById('toggle-btn');
        togglebtn.onclick=function(){
            if (designform.style.display=='block') {
                designform.style.display='none';
                togglebtn.innerHTML='显示面板';
                window.scrollTo(0,100);
            }
            else{
                designform.style.display='block';
                togglebtn.innerHTML='隐藏面板';
                window.scrollTo(0,100);
            }
        }
        </script>
        <div class="result-bar">
            <span>共有<?php echo $TotalRecord; ?>个结果</span>
            <span>第<?php echo ($offset + 1) . '-' . ($offset + count($result)); ?>个结果</span>
            <span class="set-r-num">每页显示
            <select id="set-r-num">
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="80">80</option>
                <option value="100">100</option>
                <option value="150">150</option>
                <option value="200">200</option>
            </select>
            个结果
            </span>
            <script type="text/javascript">
                var SetNum=document.getElementById('set-r-num');
                var options=SetNum.getElementsByTagName('option');
                var PageNumVal=<?php echo $length; ?>;
                var IsExe=false;
                for (var i = 0; i < options.length; i++) {
                    if (options[i].value==PageNumVal) {
                        IsExe=true;
                        break;
                    }
                }
                if (!IsExe) {
                    SetNum.options.add(new Option( PageNumVal, PageNumVal));
                }
                SetNum.value=PageNumVal;
                SetNum.onchange=function(){
                    var url=window.location.href;
                    var reg=/(&length=\d{1,})/;
                    var regoffset=/(&offset=\d{1,})/;
                    if (regoffset.test(url)) {
                        url=url.replace(regoffset,'');
                    }
                    if (reg.test(url)) {
                        window.location.href=url.replace(reg,'&length='+SetNum.value);
                    }
                    else{
                        window.location.href+='&length='+SetNum.value;
                    }
                }
            </script>
        </div>
        <div id="mask">
            <div id="box"><a id="close" href="javascript:void(0)">X</a><img id="loading" src="/images/tool/loading.gif"><img id="image" alt="图片预览"></div>
        </div>
        <script type="text/javascript" src="js/mask.js"></script>
        <div class="article-list">
            <div class="table">
                <div class="article-header">
                    <div class="table-id"><div>序号</div></div>
                    <div class="table-name">机构名称</div>
                    <div class="table-tag">类别</div>
                    <div class="table-time">发布时间</div>
                </div>
<?php
}
    ?>
                <div class="item">
                    <div class="article-id"><div><?php echo ($offset + 1) + $key; ?></div></div>
                    <div class="article-box">
                        <div class="row">
                            <div class="article-title"><a href="/article?a=<?php echo $value['ID']; ?>" target="_blank"><?php echo $value['Title']; ?></a></div>
                            <div class="article-tag">
                            <?php foreach ($value['Tag'] as $tkey => $tag): ?>
                                <a href="javascript:void(0)"><?php echo $tag; ?></a>
                            <?php endforeach?>
                            </div>
                            <div class="article-time"><?php echo date('Y-m-d', strtotime($value['Time'])); ?></div>
                        </div>
                        <div class="row">
                            <div class="article-summary">
                                <div class="item-name">简介:</div>
                                <div class="item-text"><?php echo $value['Summary']; ?></div>
                            </div>
                            <div class="article-examples">
                                <div class="item-name">实例：</div>
                                <div class="item-text">
                                <?php foreach ($value['Example'] as $ekey => $example): ?>
                                    <a href="<?php echo $example['url']; ?>" onclick="document.getElementById('image').src=this.href;document.getElementById('mask').style.display='block';return false;" title="点击查看"><?php echo $example['name']; ?></a>
                                <?php endforeach?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php
if ($key == count($result) - 1) {
        ?>
            </div>
        </div>
        <div class="pagination-btns">
            <div class="pagination"></div>
        </div>
        <script type="text/javascript">
        var article=document.getElementsByClassName('item');
        for (var i = 0; i < article.length; i++) {
            if (i%2==1) {
                article[i].setAttribute('style','background-color:#f8f8f8;');
            }
            else{
                article[i].setAttribute('style','background-color:#ffffff;');
            }
        }
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
<?php
}
}
?>
    </div>
</div>
<?php include "../includes/footer.inc.php";?>
<script type="text/javascript" src="js/check.js"></script>
</body>
</html>