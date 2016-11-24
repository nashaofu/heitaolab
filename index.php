<?php
header("content-type:text/html;charset=utf-8");
require_once $_SERVER['DOCUMENT_ROOT'] . "/common/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-article.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-manage.php";
$article  = new Article();
$Carousel = $article->CarouselLoader(6);
$New      = $article->Loader('', '', 'publish', 0, 7);
$Hot      = $article->Loader('', '', 'publish', 0, 7, 'HitCount');
$manage   = new Manage();
$help     = $manage->Loader('help', 'true', 0, 5, 'HitCount');
$Notice   = $manage->Loader('notice', 'true', 0, 5);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="黑桃Lab,机构设计,机械设计,面向运动任务特征,机构库,机构设计平台">
    <meta name="description" content="黑桃Lab - 领先的面向运动任务特征的机构设计平台">
    <title>黑桃Lab - 领先的机构设计平台</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link rel="bookmark" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" type="text/css" href="css/menu.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <link rel="stylesheet" type="text/css" href="css/carousel.css">
    <script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
</head>
<body>
<?php include "includes/header.inc.php";?>
<div class="container home">
    <div class="wrapper">
        <div id="carousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
            <?php
for ($i = 0; $i < count($Carousel); $i++) {
    $classname = 'noactive';
    if ($i == 0) {
        $classname = 'active';
    }
    ?>
                <li data-target="#carousel" data-slide-to="<?php echo $i; ?>" class="<?php echo $classname; ?>"></li>
            <?php
}
?>
            </ol>
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <?php foreach ($Carousel as $key => $value):
    $classname = 'noactive';
    if ($key == 0) {
        $classname = ' active';
    }
    ?>
		                <div class="item <?php echo $classname; ?>">
		                    <a href="article/?a=<?php echo $value['ID']; ?>">
		                    <img alt="<?php echo $value['Title'] ?>" src="<?php echo $value['Carousel']; ?>">
		                    <div class="carousel-caption">
		                        <div class="carousel-caption-title"><?php echo $value['Title'] ?></div>
		                        <div id="carousel-caption-summary" class="carousel-caption-summary"><marquee class="marquee" behavior="scroll" scrollamount="1.5" direction="up"><?php echo $value['Summary'] ?></marquee></div>
		                    </div>
		                    </a>
		                </div>
		                <?php endforeach?>
            </div>
            <!-- Controls -->
            <a class="left carousel-control" href="#carousel" role="button" data-slide="prev"> <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span><span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel" role="button" data-slide="next"> <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span><span class="sr-only">Next</span>
            </a>
        </div>
        <script type="text/javascript">
        function resize(){
            $('#carousel').height(function(){
               $(this).height($(this).width()*460/800);
            });
        }
        window.addEventListener('load',resize,false);
        window.addEventListener('resize',resize,false);
        </script>
        <!-- JavaScript Includes -->
        <script src="js/carousel.js"></script>
    </div>
    <div class="articles">
        <ul class="nav">
            <li><a href="#hot">热门机构</a></li>
            <li><a href="#new">最新机构</a></li>
            <li><a href="#help">常见帮助</a></li>
            <li><a href="#notice">公告</a></li>
        </ul>
        <ul class="section">
            <li>
                <div class="title">热门机构<a class="glyphicon glyphicon-link" aria-hidden="true" name="hot"></a></div>
                <?php foreach ($Hot as $key => $value): ?>
                <a href="article/?a=<?php echo $value['ID']; ?>">
                    <span class="article-title"><?php echo $value['Title']; ?></span>
                    <span class="article-time"><?php echo date('Y-m-d', strtotime($value['Time'])); ?></span>
                </a>
                <?php endforeach?>
            </li>
            <li>
            <div class="title">最新机构<a class="glyphicon glyphicon-link" aria-hidden="true" name="new"></a></div>
            <?php foreach ($New as $key => $value): ?>
                <a href="article/?a=<?php echo $value['ID']; ?>">
                    <span class="article-title"><?php echo $value['Title']; ?></span>
                    <span class="article-time"><?php echo date('Y-m-d', strtotime($value['Time'])); ?></span>
                </a>
            <?php endforeach?>
            </li>
            <li>
            <div class="title">常见帮助<a class="glyphicon glyphicon-link" aria-hidden="true" name="help"></a></div>
            <?php foreach ($help as $key => $value): ?>
                <a href="support/?s=<?php echo $value['ID']; ?>">
                    <span class="article-title"><?php echo $value['Title']; ?></span>
                    <span class="article-time"><?php echo date('Y-m-d', strtotime($value['Time'])); ?></span>
                </a>
            <?php endforeach?>
            </li>
            <li>
            <div class="title">公告<a class="glyphicon glyphicon-link" aria-hidden="true" name="notice"></a></div>
            <?php foreach ($Notice as $key => $value): ?>
                <a href="support/?s=<?php echo $value['ID']; ?>">
                    <span class="article-title"><?php echo $value['Title']; ?></span>
                    <span class="article-time"><?php echo date('Y-m-d', strtotime($value['Time'])); ?></span>
                </a>
            <?php endforeach?>
            </li>
        </ul>
    </div>
</div>
<?php include "includes/footer.inc.php";?>
</body>
</html>