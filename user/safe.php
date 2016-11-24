<?php
header("content-type:text/html;charset=utf-8");
require_once $_SERVER['DOCUMENT_ROOT'] . "/common/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-user.php";
session_start();
$user = new User();
if (isset($_GET['safe'])) {
    if (!empty($_GET['safe'])) {
        if ($_GET['safe'] == 'modifypwd') {
            if (!empty($_SESSION['ID'])) {
                $user->SafeModifypwd();
            } else {
                PageJump("login.php?url={$_SERVER['PHP_SELF']}?safe=modifypwd");
            }
        } elseif ($_GET['safe'] == 'security') {
            if (!empty($_SESSION['ID'])) {
                $user->SafeSecurity();
            } else {
                PageJump("login.php?url={$_SERVER['PHP_SELF']}?safe=security");
            }
        } else {
            PageJump("{$_SERVER['PHP_SELF']}");
        }
    } else {
        PageJump("{$_SERVER['PHP_SELF']}");
    }
}
if (isset($_GET['resetpwd'])) {
    if (!empty($_GET['resetpwd'])) {
        if ($_GET['resetpwd'] == 'type') {
            if (isset($_POST['UserName']) && isset($_POST['captchasText']) && isset($_SESSION['CAPTCHAS'])) {
                if (!empty($_POST['UserName']) && !empty($_POST['captchasText']) && !empty($_SESSION['CAPTCHAS'])) {
                    if (strtolower($_POST['captchasText']) == strtolower($_SESSION['CAPTCHAS'])) {
                        unset($_SESSION['CAPTCHAS']);
                        $user->SafeResetpwd();
                    } else {
                        unset($_SESSION['CAPTCHAS']);
                        $_SESSION['Notice'] = "验证码错误！";
                        PageJump("{$_SERVER['PHP_SELF']}");
                    }
                } else {
                    $_SESSION['Notice'] = "填写不完整！";
                    PageJump("{$_SERVER['PHP_SELF']}");
                }
            } else {
                if (empty($_COOKIE['Resetpwd']) || empty($_SESSION['ResetMail']) || empty($_SESSION['HiddenMail'])) {
                    unset($_SESSION['ResetMail']);
                    unset($_SESSION['HiddenMail']);
                    PageJump("{$_SERVER['PHP_SELF']}");
                }
            }
        } elseif ($_GET['resetpwd'] == 'reset') {
            if (isset($_POST['codeText'])) {
                setcookie("Resetpwd", "reset", time() + 3);
                if (!empty($_POST['codeText'])) {
                    $user->SafeResetpwd();
                } else {
                    $_SESSION['Notice'] = "请填写验证码！";
                    PageJump("{$_SERVER['PHP_SELF']}?resetpwd=type");
                }
            } elseif (isset($_POST['securityText'])) {
                setcookie("Resetpwd", "reset", time() + 3);
                if (!empty($_POST['securityText'])) {
                    $user->SafeResetpwd();
                } else {
                    $_SESSION['Notice'] = "请填写密保答案！";
                    PageJump("{$_SERVER['PHP_SELF']}?resetpwd=type");
                }
            } else {
                if (empty($_COOKIE['Resetpwd']) || empty($_SESSION['ResetMail'])) {
                    unset($_SESSION['ResetMail']);
                    unset($_SESSION['HiddenMail']);
                    PageJump("{$_SERVER['PHP_SELF']}");
                }
            }
        } elseif ($_GET['resetpwd'] == 'success') {
            if (isset($_POST['passwordText'])) {
                setcookie("Resetpwd", "success", time() + 3);
                if (!empty($_POST['passwordText'][0]) && !empty($_POST['passwordText'][1])) {
                    $user->SafeResetpwd();
                } else {
                    $_SESSION['Notice'] = "密码填写不完整！";
                    PageJump("{$_SERVER['PHP_SELF']}?resetpwd=reset");
                }
            } else {
                if (empty($_COOKIE['Resetpwd'])) {
                    unset($_SESSION['ResetMail']);
                    unset($_SESSION['HiddenMail']);
                    PageJump("{$_SERVER['PHP_SELF']}");
                }
            }
        } else {
            PageJump("{$_SERVER['PHP_SELF']}");
        }
    } else {
        PageJump("{$_SERVER['PHP_SELF']}");
    }
} else {
    if (isset($_SESSION['ResetMail'])) {
        unset($_SESSION['ResetMail']);
    }
    if (isset($_SESSION['HiddenMail'])) {
        unset($_SESSION['HiddenMail']);
    }
    if (isset($_SESSION['SecurityQ'])) {
        unset($_SESSION['SecurityQ']);
    }
    if (isset($_SESSION['SecurityA'])) {
        unset($_SESSION['SecurityA']);
    }
    if (isset($_SESSION['YZM'])) {
        unset($_SESSION['YZM']);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>安全中心</title>
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
<div class="container safe">
    <h2 class="safe-title">安全中心</h2>
    <div class="safe-bar">
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>">找回密码</a>
        <a href="<?php echo $_SERVER['PHP_SELF'] . '?safe=modifypwd'; ?>">修改密码</a>
        <a href="<?php echo $_SERVER['PHP_SELF'] . '?safe=security'; ?>">密保工具</a>
    </div>
    <?php SetNotice("2");?>
    <?php if (empty($_GET['safe'])) {?>
    <div class="safe-container safe-resetpwd">
        <?php if (empty($_GET['resetpwd'])) {?>
        <div class="safe-resetpwd-box">
            <h2 class="safe-container-title">1.填写账号</h2>
            <form id="resetpwd-form" action="<?php echo $_SERVER['PHP_SELF']; ?>?resetpwd=type" method="post">
                <div>
                    <label>请填写您需要找回的帐号：</label>
                    <input id="usernametextbox" type="text" maxlength="30" placeholder="邮箱" name="UserName">
                    <div class="warn">邮箱格式不正确！</div>
                </div>
                <div>
                    <div class="safe-resetpwd-codebox">
                        <input id="captchastextbox" type="text" maxlength="4" placeholder="请输入验证码" autocomplete="off" name="captchasText">
                        <a href="javascript:void(0)"><img src="../common/captchas.php" onclick="this.src='../common/captchas.php?id='+Math.random()" alt="验证码" title="点击切换验证码"></a>
                        <div class="warn">验证码格式有误，不区分大小写！</div>
                    </div>
                </div>
                <div>
                    <input class="button" type="submit" value="下一步">
                </div>
            </form>
        </div>
        <?php } elseif (!empty($_GET['resetpwd']) && $_GET['resetpwd'] == "type") {?>
        <div class="safe-resetpwd-box">
            <h2 class="safe-container-title">2.验证账号</h2>
            <div class="safe-resetpwd-type-btnbox">
                <div>您正在为<span><?php echo $_SESSION['HiddenMail']; ?></span>找回密码,请选择找回方式:</div>
                <div>
                    <div>
                        <a class="safe-resetpwd-type-btn" href="javascript:void(0)">邮箱验证</a>
                        <a class="safe-resetpwd-type-btn" href="javascript:void(0)">密保验证</a>
                    </div>
                </div>
            </div>
            <form class="safe-resetpwd-type" id="resetpwd-mail-form" action="<?php echo $_SERVER['PHP_SELF']; ?>?resetpwd=reset" method="post">
                <div>
                    <h2>您正在使用邮箱验证</h2>
                </div>
                <div>
                    <div>邮箱：<span><?php echo $_SESSION['HiddenMail']; ?></span></div>
                    <input class="mail" type="hidden" value="<?php echo $_SESSION['ResetMail']; ?>">
                </div>
                <div>
                    <div class="safe-resetpwd-codebox">
                        <input id="codetextbox" type="text" maxlength="6" placeholder="请输入验证码" autocomplete="off" name="codeText">
                        <a class="sendcode" href="javascript:void(0)">发送验证码</a>
                        <div class="warn" id="warn-mail">验证码格式有误！</div>
                    </div>
                </div>
                <div>
                    <input class="button" type="submit" value="立即验证">
                </div>
                <div class="return-type">返回使用<a class="return-type-btn" href="javascript:void(0)">密保验证</a></div>
            </form>
            <script type="text/javascript" src="js/authentication.js"></script>
            <form class="safe-resetpwd-type" id="resetpwd-security-form" action="<?php echo $_SERVER['PHP_SELF']; ?>?resetpwd=reset" method="post">
                <div>
                    <h2>您正在使用密保验证</h2>
                </div>
                <div>
                    <div>密保问题：<span id="SecurityQ"><?php echo $_SESSION['SecurityQ']; ?></span></div>
                </div>
                <div class="SecurityA">
                    <label>密保答案：</label>
                    <input id="securitytextbox" type="text" maxlength="20" placeholder="密保答案" name="securityText">
                    <div class="warn" id="warn-security">请填写密保答案！</div>
                </div>
                <div class="SecurityA">
                    <input class="button" type="submit" value="立即验证">
                </div>
                <div class="return-type">返回使用<a class="return-type-btn" href="javascript:void(0)">邮箱验证</a></div>
            </form>
            <script type="text/javascript">
            var TypeBtnBox=document.getElementsByClassName("safe-resetpwd-type-btnbox")[0];
            var TypeBtn=document.getElementsByClassName("safe-resetpwd-type-btn");
            var PwdType=document.getElementsByClassName("safe-resetpwd-type");
            var SecurityQ=document.getElementById('SecurityQ');
            var SecurityA=document.getElementsByClassName("SecurityA");
            var ReturnTypeBtn=document.getElementsByClassName("return-type-btn");
            for (var i = 0; i < TypeBtn.length; i++) {
                TypeBtn[i].index=i;
                TypeBtn[i].onclick=function(){
                    for (var i = 0; i < PwdType.length; i++) {
                        PwdType[i].style.display="none";
                    }
                    TypeBtnBox.style.display="none";
                    PwdType[this.index].style.display="block";
                }
            }
            if(SecurityQ.innerHTML=="您未设置密保问题，请使用邮箱验证！"){
                for (var i = 0; i < SecurityA.length; i++) {
                    SecurityA[i].style.display="none";
                }
            }
            for (var i = 0; i < ReturnTypeBtn.length; i++) {
                ReturnTypeBtn[i].onclick=function(){
                    for (var i = 0; i < PwdType.length; i++) {
                        PwdType[i].style.display="none";
                    }
                        TypeBtnBox.style.display="block";
                }
            }
            </script>
        </div>
        <?php } elseif (!empty($_GET['resetpwd']) && $_GET['resetpwd'] == "reset") {?>
        <div class="safe-resetpwd-box">
            <h2 class="safe-container-title">3.重置密码</h2>
            <form id="resetpwd-reset-form" action="<?php echo $_SERVER['PHP_SELF']; ?>?resetpwd=success" method="post">
                <div>
                    <label>新密码：</label>
                    <input class="resetpwd-reset-password" type="password" maxlength="20" placeholder="密码(长度为8-20个字符，可为数字、字母、下划线，区分大小写，至少包含两种类型)" name="passwordText[]">
                    <div class="warn">长度为8-20个字符，可为数字、字母、下划线，区分大小写，至少包含两种类型！</div>
                </div>
                <div>
                    <label>确认密码：</label>
                    <input class="resetpwd-reset-password" type="password" maxlength="20" placeholder="确认密码" name="passwordText[]">
                    <div class="warn">两次输入密码不一致，请重新输入！</div>
                </div>
                <div>
                    <input class="button" type="submit" value="确认修改">
                </div>
            </form>
        </div>
        <?php } elseif (!empty($_GET['resetpwd']) && $_GET['resetpwd'] == "success") {?>
        <div class="safe-resetpwd-box">
            <h2 class="safe-container-title">4.完成</h2>
            <div class="safe-resetpwd-success">
                <h1>恭喜您，密码修改成功！</h1>
                <div>请牢记您的密码，如果丢失可通过邮箱或者密保的方式找回！</div>
            </div>
        </div>
        <?php }?>
    </div>
    <?php } elseif (!empty($_GET['safe']) && $_GET['safe'] == 'modifypwd') {?>
    <div class="safe-container safe-modifypwd">
        <h2 class="safe-container-title">修改密码</h2>
        <form id="modifypwd-form" action="<?php echo $_SERVER['PHP_SELF']; ?>?safe=modifypwd" method="post">
            <div>
                <label>原密码：</label>
                <input class="modifypwd-password" type="password" maxlength="20" placeholder="原密码" name="passwordText[]">
                <div class="warn">密码格式不正确！</div>
            </div>
            <div>
                <label>新密码：</label>
                <input class="modifypwd-password" type="password" maxlength="16" placeholder="密码(长度为8-20个字符，可为数字、字母、下划线，区分大小写，至少包含两种类型)" name="passwordText[]">
                <div class="warn">长度为8-20个字符，可为数字、字母、下划线，区分大小写，至少包含两种类型！</div>
            </div>
            <div>
                <label>确认密码：</label>
                <input class="modifypwd-password" type="password" maxlength="16" placeholder="确认密码" name="passwordText[]">
                <div class="warn">两次输入密码不一致，请重新输入！</div>
            </div>
            <div>
                <div>
                    <input class="button" type="submit" value="确认修改">
                    <input class="button" type="reset" value="重置">
                </div>
            </div>
        </form>
    </div>
    <?php } elseif (!empty($_GET['safe']) && $_GET['safe'] == 'security') {?>
    <div class="safe-container safe-security">
        <h2 class="safe-container-title">密保问题</h2>
        <form id="security-form" action="<?php echo $_SERVER['PHP_SELF']; ?>?safe=security" method="post">
            <div>
                <label>请填写注册时的邮箱：</label>
                <input id="usernametextbox" class="mail" type="text" maxlength="30" placeholder="请填写注册时的邮箱" autocomplete="off" name="mailText">
                <div class="warn">邮箱格式不正确！</div>
            </div>
            <div>
                <label>请填写验证码：</label>
                <div class="safe-security-codebox">
                    <input id="codetextbox" type="text" maxlength="6" placeholder="验证码" autocomplete="off" name="codeText">
                    <a class="sendcode" href="javascript:void(0)">发送验证码</a>
                    <div class="warn">验证码格式有误！</div>
                </div>
            </div>
            <div>
                <label>请选择密保问题：</label>
                <select id="securityQbox" class="safe-security-box" name="security[]">
                    <option value="NULL">请选择一个问题</option>
                    <option value="你最喜欢的明星是谁？">你最喜欢的明星是谁？</option>
                    <option value="你的偶像是谁？">你的偶像是谁？</option>
                    <option value="你的出生地是哪里？">你的出生地是哪里？</option>
                    <option value="你大学辅导员的名字？">你大学辅导员的名字？</option>
                    <option value="你父亲的名字？">你父亲的名字？</option>
                    <option value="你母亲的名字？">你母亲的名字？</option>
                    <option value="对你影响最大的人？">对你影响最大的人？</option>
                </select>
                <div class="warn">请选择一个问题！</div>
            </div>
            <div>
                <label>请填写密保答案：</label>
                <input id="securityAbox" type="text" maxlength="20" placeholder="密保答案" name="security[]">
                <div class="warn">请填写密保答案！</div>
            </div>
            <div>
                <div>
                    <input class="button" type="submit" value="修改">
                    <input class="button" type="reset" value="重置">
                </div>
            </div>
        </form>
        <script type="text/javascript" src="js/authentication.js"></script>
    </div>
    <?php }?>
</div>
<?php include "../includes/footer.inc.php";?>
<script type="text/javascript">
var SafeBarBtn = document.getElementsByClassName('safe-bar')[0].getElementsByTagName("a");
for (var i = 0; i <= SafeBarBtn.length - 1; i++) {
    SafeBarBtn[i].className = "";
}
<?php
if (empty($_GET['safe'])) {
    echo "SafeBarBtn[0].className = 'on';";
} elseif (!empty($_GET['safe']) && $_GET['safe'] == 'modifypwd') {
    echo "SafeBarBtn[1].className = 'on';";
} elseif (!empty($_GET['safe']) && $_GET['safe'] == 'security') {
    echo "SafeBarBtn[2].className = 'on';";
}
?>
</script>
<script type="text/javascript" src="js/checkf.js"></script>
</body>
</html>