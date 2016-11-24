<?php
header("content-type:text/html;charset=utf-8");
require_once $_SERVER['DOCUMENT_ROOT'] . "/common/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-article.php";
session_start();
if (empty($_SESSION['ID'])) {
    $_SESSION['Notice'] = '请先登录！';
}
if (!empty($_SESSION['Notice'])) {
    if (!empty($_SESSION['Role']) && ($_SESSION['Role'] == 'Admin' || $_SESSION['Role'] == 'Root')) {
        $_SESSION['Notice'] = '您没有权限浏览该页面！';
    }
}
if (empty($_SESSION['Notice'])) {
    if (!empty($_GET['a']) && is_numeric($_GET['a'])) {
        $article = new Article();
        $id      = $_GET['a'];
        $result  = $article->Browse($id, 'ALL');
        if (empty($result)) {
            $_SESSION['Notice'] = '您浏览的内容已过期！';
        }
    } else {
        $_SESSION['Notice'] = '页面不存在！';
    }
}
if (!empty($_SESSION['Notice'])) {
    $NoticeBox = '<div id="Notice" style="width: 300px;height: 50px;line-height: 50px;background: rgba(250,250,200,0.98);margin: -33px -158px;padding: 7px;position: fixed;top: 50%;left: 50%;color: red;font-family: Arial, Helvetica, sans-serif;font-size: 24px;font-weight: bold;text-align: center;border: 1px solid #fff;box-shadow: 0 0 10px #ccc;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;word-wrap: break-word;word-break: break-all;overflow-wrap: break-word;z-index: 10;">' . $_SESSION['Notice'] . '</div>';
    unset($_SESSION['Notice']);
    die($NoticeBox);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>设计平台 - <?php echo $result['Title']; ?></title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">
    <link rel="bookmark" type="image/x-icon" href="../favicon.ico">
    <link rel="stylesheet" type="text/css" href="css/view.css">
    <link rel="stylesheet" type="text/css" href="../article/css/mask.css">
</head>
<body>
<div class="container article-detail">
    <div class="article">
        <article>
            <h1 class="article-header"><?php echo $result['Title']; ?></h1>
            <div class="article-summary">简介:<span><?php echo $result['Summary']; ?></span></div>
            <div class="article-body"><?php echo $result['Body']; ?>
            </div>
            <div class="article-example">
                <span>实例:</span>
                <?php
foreach ($result['Example'] as $ekey => $example) {
    ?>
                <a href="<?php echo $example['url']; ?>" onclick="document.getElementById('image').src=this.href;document.getElementById('mask').style.display='block';return false;" title="点击查看"><?php echo $example['name']; ?></a>
                <?php
}
?>
            </div>
            <div class="article-footer">
                <div>
                    <a class="publisher" href="/user/?id=<?php echo $result['Publisher']['ID']; ?>" title="点击查看主页"><img class="publisher-avatar" src="/user/avatar/<?php echo $result['Publisher']['Avatar']; ?>" alt="头像"><?php echo $result['Publisher']['Name']; ?></a>
                    <span>发布于<a class="publisher-time" href="javascript:void(0)" title="发布时间"><?php echo date('Y年m月d日', strtotime($result['Time'])); ?></a></span>
                </div>
            </div>
            <div class="article-tag">
                <span>类别:</span>
                <?php foreach ($result['Tag'] as $key => $tag): ?>
                    <a href="javascript:void(0)"><?php echo $tag; ?></a>
                <?php endforeach?>
            </div>
        </article>
    </div>
</div>
<a id="Top" href="javascript:void(0)">TOP</a>
<script type="text/javascript">
    var Top=document.getElementById('Top');
    Top.onclick=function(){
        var timer=setInterval(function(){
            if (window.scrollY<=24) {
                window.scrollTo(0,0);
                window.clearInterval(timer);
            }
            else{
                window.scrollTo(0,window.scrollY-Math.random()*200);
            }
        },10);
    }
    window.onscroll=function(){
        if (window.scrollY>150 && window.innerWidth>767) {
            Top.style.display='block';
        }
        else{
            Top.style.display='none';
        }
    }
</script>
<div id="mask">
    <div id="box"><a class="close-btn" id="close" href="javascript:void(0)">X</a><img id="loading" src="/images/tool/loading.gif"><img id="image" alt="图片预览"></div>
</div>
<script type="text/javascript" src="../article/js/mask.js"></script>
</body>
</html>