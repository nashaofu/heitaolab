<?php
header("content-type:text/html;charset=utf-8");
require_once $_SERVER['DOCUMENT_ROOT'] . "/common/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-user.php";
session_start();
if (!empty($_SESSION['ID'])) {
    PageJump("home.php?id={$_SESSION['ID']}");
} else {
    $user = new User();
    if (!empty($_GET['url'])) {
        if ($_GET['url'] == '/user/login.php' || $_GET['url'] == '/user/register.php' || $_GET['url'] == '/user/activate.php') {
            $url = '';
        } else {
            $url = '?url=' . $_GET['url'];
        }
    } else {
        $url = '';
    }
    if (!empty($_POST['UserName']) && !empty($_POST['passwordText']) && !empty($_POST['captchasText']) && !empty($_SESSION['CAPTCHAS'])) {
        if (strtolower($_POST['captchasText']) == strtolower($_SESSION['CAPTCHAS'])) {
            unset($_SESSION['CAPTCHAS']);
            $user->Login($_POST['UserName'], $_POST['passwordText']);
        } else {
            $_SESSION['Notice'] = "验证码错误！";
        }
    } else {
        if (isset($_POST['UserName']) && isset($_POST['passwordText']) && isset($_POST['captchasText'])) {
            $_SESSION['Notice'] = "填写不完整！";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登录</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">
    <link rel="bookmark" type="image/x-icon" href="../favicon.ico">
    <link rel="stylesheet" type="text/css" href="../css/menu.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="css/user.css">
</head>
<body>
<?php include "../includes/header.inc.php";?>
<div class="container login">
    <div class="log-reg-header">
        <a href="login.php">登录</a>|<a href="register.php">注册</a>
    </div>
    <h1 class="log-reg-title">登录</h1>
    <?php SetNotice("1");?>
    <form class="log-reg-form" id="login-form" action="<?php echo $_SERVER['PHP_SELF'] . $url; ?>" method="post">
        <div>
            <input class="username-textbox" id="usernametextbox" type="text" maxlength="30" placeholder="邮箱" name="UserName">
            <div class="warn">邮箱格式不正确！</div>
        </div>
        <div>
            <input class="password-textbox" id="passwordtextbox" type="password" maxlength="20" placeholder="密码" autocomplete="off" name="passwordText">
            <div class="warn">密码格式不正确！</div>
        </div>
        <div>
            <div class="captchas-box">
                <input id="captchastextbox" type="text" maxlength="4" placeholder="验证码" autocomplete="off" name="captchasText">
                <a href="javascript:void(0)"><img src="../common/captchas.php" onclick="this.src='../common/captchas.php?id='+Math.random()" alt="验证码" title="点击切换验证码"></a>
            </div>
            <div class="warn">验证码格式有误，不区分大小写！</div>
        </div>
        <div class="resetpwd">
            <a href="safe.php">忘记密码</a>
        </div>
        <div>
            <input class="button" type="submit" value="登录">
            <input class="button" type="reset" value="重置">
        </div>
    </form>
    <div class="log-reg-footer">
        <div>还没有账号,立即<a href="register.php">注册</a></div>
    </div>
</div>
<?php include "../includes/footer.inc.php";?>
<script type="text/javascript" src="js/checkf.js"></script>
</body>
</html>