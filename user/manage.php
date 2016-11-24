<?php
header("content-type:text/html;charset=utf-8");
require_once $_SERVER['DOCUMENT_ROOT'] . "/common/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-user.php";
session_start();
if (!empty($_SESSION['ID'])) {
    if (!empty($_GET['id'])) {
        if ($_GET['id'] == $_SESSION['ID']) {
            $user = new User();
            $user->Update();
            if (isset($_GET['setting'])) {
                if (!empty($_GET['setting'])) {
                    if ($_GET['setting'] != 'avatar' && $_GET['setting'] != 'binding' && $_GET['setting'] != 'privacy') {
                        PageJump("{$_SERVER['PHP_SELF']}?id={$_SESSION['ID']}");
                    }
                } else {
                    PageJump("{$_SERVER['PHP_SELF']}?id={$_SESSION['ID']}");
                }
            }
        } else {
            PageJump("{$_SERVER['PHP_SELF']}?id={$_SESSION['ID']}");
        }
    } else {
        PageJump("{$_SERVER['PHP_SELF']}?id={$_SESSION['ID']}");
    }
} else {
    PageJump("login.php?url={$_SERVER['PHP_SELF']}");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>个人设置</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">
    <link rel="bookmark" type="image/x-icon" href="../favicon.ico">
    <link rel="stylesheet" type="text/css" href="../css/menu.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <link rel="stylesheet" type="text/css" href="../css/cropper.css">
</head>
<body>
<?php include "../includes/header.inc.php";?>
<div class="container manage">
    <h2 class="manage-title">个人设置</h2>
    <div class="manage-bar">
        <a href="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $_SESSION['ID']; ?>">基本资料</a>
        <a href="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $_SESSION['ID'] . '&setting=avatar'; ?>">更换头像</a>
        <a href="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $_SESSION['ID'] . '&setting=binding'; ?>">绑定设置</a>
        <a href="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $_SESSION['ID'] . '&setting=privacy'; ?>">隐私设置</a>
    </div>
    <?php SetNotice("2");?>
    <?php if (empty($_GET['setting'])) {?>
    <div class="manage-container manage-info">
        <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $_SESSION['ID']; ?>" method="post">
            <div class="manage-info-item">
                <label>昵称：</label>
                <input type="text" maxlength="12" value="<?php echo $_SESSION['Name']; ?>" name="Name">
            </div>
            <div class="manage-info-item">
                <label>介绍：</label>
                <textarea maxlength="280" name="Introduction"><?php echo $_SESSION['Introduction']; ?></textarea>
            </div>
            <div class="manage-info-item">
                <label>性别：</label>
                <div>
                    <label><input type="radio" <?php if ($_SESSION['Gender'] == "男") {echo "checked='on'";}?> value="男" name="Gender">男</label>
                    <label><input type="radio" <?php if ($_SESSION['Gender'] == "女") {echo "checked='on'";}?> value="女" name="Gender">女</label>
                    <label><input type="radio" <?php if ($_SESSION['Gender'] == "保密") {echo "checked='on'";}?> value="保密" name="Gender">保密</label>
                </div>
            </div>
            <div class="manage-info-item manage-info-birthday">
                <label>生日：</label>
                <div>
                    <select id="YYYY" name="Birthday[]"></select><span>年</span>
                    <select id="MM" name="Birthday[]"></select><span>月</span>
                    <select id="DD" name="Birthday[]"></select><span>日</span>
                </div>
            </div>
            <div class="manage-info-item manage-info-area">
                <label>地区：</label>
                <div>
                    <select id="zone" name="Area[]"></select>
                    <select id="city" name="Area[]"></select>
                </div>
            </div>
            <div class="manage-info-item">
                <div><input class="button" type="submit" value="保存"></div>
            </div>
        </form>
        <script type="text/javascript" src="js/manage.js"></script>
        <script type="text/javascript">
        var startY=<?php echo date('Y', strtotime($_SESSION['Birthday'])); ?>;
        var startM=<?php echo date('m', strtotime($_SESSION['Birthday'])); ?>;
        var startD=<?php echo date('d', strtotime($_SESSION['Birthday'])); ?>;
        //初始化生日
        InitDate(startY,startM,startD);
        var starZ="<?php echo explode(',', $_SESSION['Area'])[0]; ?>";
        var starC="<?php echo explode(',', $_SESSION['Area'])[1]; ?>";
        //初始化地区
        INITArea(starZ,starC);
        </script>
    </div>
    <?php } elseif (!empty($_GET['setting']) && $_GET['setting'] == "avatar") {?>
    <div class="manage-container manage-avatar">
        <div class="avatar-box">
            <h2>当前头像：</h2>
            <img src="/user/avatar/<?php echo $_SESSION['Avatar']; ?>" alt="头像预览">
        </div>
        <div>
            <label for="file-avatar">上传头像</label>
            <div class="image-notice">支持jpg、png、gif格式的图片，且文件小于5M</div>
            <div class="cropper-container">
                <div class="cropper">
                    <img class="cropper-img" src="/images/tool/default_cover.png">
                    <div class="cropper-mask"></div>
                    <img class="cropper-handle-bg" src="/images/tool/default_cover.png">
                    <div class="cropper-handle">
                        <div class="cropper-handle-zoom"></div>
                    </div>
                </div>
            </div>
            <form id="avatar-upload-form" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $_SESSION['ID']; ?>" method="post" enctype="multipart/form-data">
                <input class="file-avatar-input" id="file-avatar" type="file" accept="image/*" hidefocus="true" name="Avatar">
                <input id="avatar-data" type="hidden" name="Avatar-data">
                <div>
                    <input class="button" type="submit" value="保存">
                    <input id="reset" class="button" type="reset" value="取消">
                </div>
            </form>
        </div>
<script type="text/javascript" src="../js/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="../js/jquery.dragble.js"></script>
<script type="text/javascript" src="../js/jquery.resizable.js"></script>
<script type="text/javascript" src="js/avatar.js"></script>
    </div>
    <?php } elseif (!empty($_GET['setting']) && $_GET['setting'] == "binding") {?>
    <div class="manage-container manage-binding">
        <div>
            <h2>绑定设置</h2>
        </div>
    </div>
    <?php } elseif (!empty($_GET['setting']) && $_GET['setting'] == "privacy") {?>
    <div class="manage-container manage-privacy">
        <div>
            <h2>隐私设置</h2>
        </div>
    </div>
    <?php }?>
</div>
<?php include "../includes/footer.inc.php";?>
<script type="text/javascript">
var ManageBarBtn = document.getElementsByClassName('manage-bar')[0].getElementsByTagName("a");
var ManageContainer = document.getElementsByClassName('manage-container');
<?php
if (empty($_GET['setting'])) {
    echo "ManageBarBtn[0].className = 'on';";
} elseif (!empty($_GET['setting']) && $_GET['setting'] == 'avatar') {
    echo "ManageBarBtn[1].className = 'on';";
} elseif (!empty($_GET['setting']) && $_GET['setting'] == 'binding') {
    echo "ManageBarBtn[2].className = 'on';";
} elseif (!empty($_GET['setting']) && $_GET['setting'] == 'privacy') {
    echo "ManageBarBtn[3].className = 'on';";
}
?>
ManageContainer[0].style.display="block";
</script>
</body>
</html>