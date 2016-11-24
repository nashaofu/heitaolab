<?php
header("content-type:text/html;charset=utf-8");
require_once $_SERVER['DOCUMENT_ROOT'] . "/common/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-user.php";
session_start();
if (!empty($_SESSION['ID'])) {
    PageJump("home.php?id={$_SESSION['ID']}");
} else {
    $user = new User();
    if (!empty($_POST['UserName']) && !empty($_POST['codeText']) && !empty($_POST['passwordText']) && !empty($_POST['captchasText']) && !empty($_POST['checkbox']) && !empty($_SESSION['CAPTCHAS'])) {
        if ($_POST['checkbox'] == "on") {
            if (strtolower($_POST['captchasText']) == strtolower($_SESSION['CAPTCHAS'])) {
                unset($_SESSION['CAPTCHAS']);
                if (!empty($_SESSION['YZM'])) {
                    if ($_POST['codeText'] == $_SESSION['YZM']) {
                        unset($_SESSION['YZM']);
                        if ($_POST['passwordText'][0] == $_POST['passwordText'][1]) {
                            $user->Register($_POST['UserName'], $_POST['passwordText'][0]);
                        } else {
                            $_SESSION['Notice'] = "两次输入密码不一致！";
                        }
                    } else {
                        unset($_SESSION['YZM']);
                        $_SESSION['Notice'] = "邮箱激活码错误！请重新申请！";
                    }
                } else {
                    unset($_SESSION['YZM']);
                    $_SESSION['Notice'] = "您未申请激活码！";
                }
            } else {
                $_SESSION['Notice'] = "验证码错误！";
            }
        } else {
            $_SESSION['Notice'] = "您必须同意条款才能注册！";
        }
    } else {
        if ((isset($_POST['UserName']) && isset($_POST['codeText']) && isset($_POST['passwordText']) && isset($_POST['captchasText'])) || isset($_POST['checkbox'])) {
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
    <title>注册</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">
    <link rel="bookmark" type="image/x-icon" href="../favicon.ico">
    <link rel="stylesheet" type="text/css" href="../css/menu.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <script type="text/javascript" src="../js/ajax.js"></script>
</head>
<body>
<?php include "../includes/header.inc.php";?>
<div class="container register">
    <div class="log-reg-header">
        <a href="login.php">登录</a>|<a href="register.php">注册</a>
    </div>
    <h1 class="log-reg-title">注册</h1>
    <?php SetNotice("1");?>
    <form class="log-reg-form" id="register-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div>
            <input class="username-textbox" id="usernametextbox" type="text" maxlength="30" placeholder="邮箱(请使用您常用的邮箱作为账号，不区分大小写)" name="UserName">
            <div class="warn">邮箱格式不正确！</div>
        </div>
        <div>
            <div class="code-box">
                <input id="codeTextbox" type="text" maxlength="6" placeholder="请输入邮箱激活码" autocomplete="off" name="codeText">
                <a class="sendcode" href="javascript:void(0)">发送激活码</a>
                <div class="warn">激活码格式错误！</div>
            </div>
        </div>
        <div>
            <input class="password-textbox" type="password" maxlength="20" placeholder="密码(长度为8-20个字符，可为数字、字母、下划线，区分大小写，至少包含两种类型)" autocomplete="off" name="passwordText[]">
            <div class="warn">长度为8-20个字符，可为数字、字母、下划线，区分大小写，至少包含两种类型！</div>
        </div>
        <div>
            <input class="password-textbox" type="password" maxlength="20" placeholder="重复密码" autocomplete="off" name="passwordText[]">
            <div class="warn">两次输入密码不一致，请重新输入！</div>
        </div>
        <div>
            <div class="captchas-box">
                <input id="captchastextbox" type="text" maxlength="4" placeholder="验证码" autocomplete="off" name="captchasText">
                <a href="javascript:void(0)"><img src="../common/captchas.php" onclick="this.src='../common/captchas.php?id='+Math.random()" alt="验证码" title="点击切换验证码"></a>
            </div>
            <div class="warn">验证码格式有误！</div>
        </div>
        <div class="checkbox">
            <label>
                <input id="checkbox" type="checkbox" checked="checked" name="checkbox"><span>我已阅读并接受</span><a href="javascript:void(0)">《黑桃Lab服务协议条款》</a>
            </label>
            <div class="warn">您必须阅读并接受协议才能继续注册</div>
        </div>
        <div>
            <input class="button" type="submit" value="注册">
            <input class="button" type="reset" value="重置">
        </div>
    </form>
    <div class="log-reg-footer">
        <div>已经有账号了,立即<a href="login.php">登录</a></div>
    </div>
</div>
<?php include "../includes/footer.inc.php";?>
<script type="text/javascript">
var SendCodeBtn = document.getElementsByClassName("sendcode");
var Mail = document.getElementById("usernametextbox");
var time;
var timer;
for (var i = 0; i <= SendCodeBtn.length - 1; i++) {
    SendCodeBtn[i].index = i;
    SendCodeBtn[i].addEventListener("click", SendCode, false);
}
function SendCode() {
    var RegEx=/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
    if (RegEx.test(Mail.value)){
        this.removeEventListener("click", SendCode, false);
        this.innerHTML = "发送中...";
        var i=this.index;
        window.clearInterval(timer);
        time = 60;
        ajax("/ajax/authentication.php", "POST", {
            UserName: Mail.value
        }, function (e) {
            if (e != 404) {
                if (e == "SendSuccess") {
                    timer = window.setInterval(function () {
                        if (time > 1) {
                            time--;
                            SendCodeBtn[i].innerHTML = "重新发送（" + time + "）";
                        } else {
                            SendCodeBtn[i].addEventListener("click", SendCode, false);
                            window.clearInterval(timer);
                            SendCodeBtn[i].innerHTML = "发送验证码";
                        }
                    }, 1000);
                } else if (e == "SendFail"){
                    SendCodeBtn[i].addEventListener("click", SendCode, false);
                    alert("邮件发送失败！");
                    SendCodeBtn[i].innerHTML = "发送验证码";
                }else if (e == "Exist") {
                    SendCodeBtn[i].addEventListener("click", SendCode, false);
                    alert("账号已经被注册了");
                    SendCodeBtn[i].innerHTML = "发送验证码";
                } else if( e == "SESSIONError") {
                    SendCodeBtn[i].addEventListener("click", SendCode, false);
                    alert("您已经登录了！请先退出当前账号");
                    SendCodeBtn[i].innerHTML = "发送验证码";
                }else if( e == "FormatError") {
                    SendCodeBtn[i].addEventListener("click", SendCode, false);
                    alert("邮箱格式错误！");
                    SendCodeBtn[i].innerHTML = "发送验证码";
                } else {
                    SendCodeBtn[i].addEventListener("click", SendCode, false);
                    alert("请求失败！");
                    SendCodeBtn[i].innerHTML = "发送验证码";
                }
            }
        });
    }
    else{
        alert("邮箱格式不正确！");
    }
}
</script>
<script type="text/javascript" src="js/checkf.js"></script>
</body>
</html>
