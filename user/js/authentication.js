var SendCodeBtn = document.getElementsByClassName("sendcode");
var Mail = document.getElementsByClassName("mail");
var time;
var timer;
for (var i = 0; i <= SendCodeBtn.length - 1; i++) {
    SendCodeBtn[i].index = i;
    SendCodeBtn[i].addEventListener("click", SendCode, false);
}
/**
 * 请求验证码
 * @param string Name 请求字段名字
 */
function SendCode(Name) {
    var RegEx = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
    if (RegEx.test(Mail[this.index].value)) {
        this.removeEventListener("click", SendCode, false);
        this.innerHTML = "发送中...";
        var i = this.index;
        window.clearInterval(timer);
        time = 60;
        ajax("/ajax/authentication.php", "POST", {
            Mail: Mail[0].value
        }, function(e) {
            if (e != 404) {
                if (e == "SendSuccess") {
                    timer = window.setInterval(function() {
                        if (time > 1) {
                            time--;
                            SendCodeBtn[i].innerHTML = "重新发送（" + time + "）";
                        } else {
                            SendCodeBtn[i].addEventListener("click", SendCode, false);
                            window.clearInterval(timer);
                            SendCodeBtn[i].innerHTML = "发送验证码";
                        }
                    }, 1000);
                } else if (e == 'SendFail') {
                    SendCodeBtn[i].addEventListener("click", SendCode, false);
                    alert("邮件发送失败！");
                    SendCodeBtn[i].innerHTML = "发送验证码";
                } else if (e == "NoMatch") {
                    SendCodeBtn[i].addEventListener("click", SendCode, false);
                    alert("邮箱与当前账号不匹配！");
                    SendCodeBtn[i].innerHTML = "发送验证码";
                } else if (e == "NoExist") {
                    SendCodeBtn[i].addEventListener("click", SendCode, false);
                    alert("账号不存在！");
                    SendCodeBtn[i].innerHTML = "发送验证码";
                } else if (e == "FormatError") {
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
    } else {
        alert("邮箱格式不正确！");
    }
}