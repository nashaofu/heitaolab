(function() {
    /**
     * 表单检测函数
     * @param data 要检测的数据
     * @param type 检测模式
     */
    function CheckF(data, type) {
        if (data == "") {
            return false;
        }
        var RegEx;
        switch (type) {
            case 1: //匹配邮箱
                RegEx = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
                break;
            case 2: //匹配密码
                RegEx = /^(?![0-9]+$)(?![a-zA-Z]+$)(?![_]+$)\w{8,20}$/;
                break;
            case 3: //匹配激活码(验证码)
                RegEx = /^\d{6}$/;
                break;
            case 4: //4位验证码匹配
                RegEx = /^[a-z0-9]{4}$/i;
                break;
            case 5: //匹配日期
                RegEx = /^[1-2][0-9][0-9][0-9]-[0-1]{0,1}[0-9]-[0-3]{0,1}[0-9]$/;
                break;
            default:
                return false;
                break;
        }
        return RegEx.test(data);
    }
    /**
     * 注册表单验证
     */
    if (document.getElementById("register-form")) {
        var registerForm = document.getElementById("register-form");
        var WarnBox = document.getElementsByClassName("warn");
        var usernameTextbox = document.getElementById("usernametextbox");
        var codeTextbox = document.getElementById("codeTextbox");
        var passwordTextbox = document.getElementsByClassName("password-textbox");
        var captchasTextbox = document.getElementById("captchastextbox");
        var checkBox = document.getElementById("checkbox");
        usernameTextbox.onchange = function() {
            WarnBox[0].style.display = "none";
            if (!CheckF(this.value, 1) && this.value != "") {
                WarnBox[0].style.display = "block";
            }
        }
        codeTextbox.onchange = function() {
            WarnBox[1].style.display = "none";
            if (!CheckF(this.value, 3) && this.value != "") {
                WarnBox[1].style.display = "block";
            }
        }
        passwordTextbox[0].onchange = function() {
            WarnBox[2].style.display = "none";
            WarnBox[3].style.display = "none";
            if (!CheckF(this.value, 2) && this.value != "") {
                WarnBox[2].style.display = "block";
            }
            if (passwordTextbox[1].value != "" && passwordTextbox[0].value != passwordTextbox[1].value) {
                WarnBox[3].style.display = "block";
            }
        }
        passwordTextbox[1].onchange = function() {
            WarnBox[3].style.display = "none";
            if (passwordTextbox[0].value != passwordTextbox[1].value && this.value != "") {
                WarnBox[3].style.display = "block";
            }
        }
        captchasTextbox.onchange = function() {
            WarnBox[4].style.display = "none";
            if (!CheckF(this.value, 4) && this.value != "") {
                WarnBox[4].style.display = "block";
            }
        }
        checkBox.onchange = function() {
            WarnBox[5].style.display = "none";
            if (this.checked == false) {
                WarnBox[5].style.display = "block";
            }
        }
        registerForm.onsubmit = function() {
            for (var i = 0; i < WarnBox.length; i++) {
                WarnBox[i].style.display = "none";
            }
            if (!CheckF(usernameTextbox.value, 1)) {
                WarnBox[0].style.display = "block";
                return false;
            }
            if (!CheckF(codeTextbox.value, 3)) {
                WarnBox[1].style.display = "block";
                return false;
            }
            if (!CheckF(passwordTextbox[0].value, 2)) {
                WarnBox[2].style.display = "block";
                return false;
            }
            if (passwordTextbox[0].value != passwordTextbox[1].value) {
                WarnBox[3].style.display = "block";
                return false;
            }
            if (!CheckF(captchasTextbox.value, 4)) {
                WarnBox[4].style.display = "block";
                return false;
            }
            if (checkBox.checked != true) {
                WarnBox[5].style.display = "block";
                return false;
            }
            return true;
        }
    }
    /**
     * 登陆表单检测
     */
    if (document.getElementById("login-form")) {
        var loginForm = document.getElementById("login-form");
        var WarnBox = document.getElementsByClassName("warn");
        var usernameTextbox = document.getElementById("usernametextbox");
        var passwordTextbox = document.getElementById("passwordtextbox");
        var captchasTextbox = document.getElementById("captchastextbox");
        usernameTextbox.onchange = function() {
            WarnBox[0].style.display = "none";
            if (!CheckF(this.value, 1) && this.value != "") {
                WarnBox[0].style.display = "block";
            }
        }
        passwordTextbox.onchange = function() {
            WarnBox[1].style.display = "none";
            if (!CheckF(this.value, 2) && this.value != "") {
                WarnBox[1].style.display = "block";
            }
        }
        captchasTextbox.onchange = function() {
            WarnBox[2].style.display = "none";
            if (!CheckF(this.value, 4) && this.value != "") {
                WarnBox[2].style.display = "block";
            }
        }
        loginForm.onsubmit = function() {
            for (var i = 0; i < WarnBox.length; i++) {
                WarnBox[i].style.display = "none";
            }
            if (!CheckF(usernameTextbox.value, 1)) {
                WarnBox[0].style.display = "block";
                return false;
            }
            if (!CheckF(passwordTextbox.value, 2)) {
                WarnBox[1].style.display = "block";
                return false;
            }
            if (!CheckF(captchasTextbox.value, 4)) {
                WarnBox[2].style.display = "block";
                return false;
            }
            return true;
        }
    }
    /**
     * 找回密码表单验证
     * @param step 修改密码所在页面步数
     */
    if (document.getElementsByClassName("safe-resetpwd-box")) {
        if (document.getElementById("resetpwd-form")) {
            var resetpwdForm = document.getElementById("resetpwd-form");
            var WarnBox = document.getElementsByClassName("warn");
            var usernameTextbox = document.getElementById("usernametextbox");
            var captchasTextbox = document.getElementById("captchastextbox");
            usernameTextbox.onchange = function() {
                WarnBox[0].style.display = "none";
                if (!CheckF(this.value, 1) && this.value != "") {
                    WarnBox[0].style.display = "block";
                }
            }
            captchasTextbox.onchange = function() {
                WarnBox[1].style.display = "none";
                if (!CheckF(this.value, 4) && this.value != "") {
                    WarnBox[1].style.display = "block";
                }
            }
            resetpwdForm.onsubmit = function() {
                for (var i = 0; i < WarnBox.length; i++) {
                    WarnBox[i].style.display = "none";
                }
                if (!CheckF(usernameTextbox.value, 1)) {
                    WarnBox[0].style.display = "block";
                    return false;
                }
                if (!CheckF(captchasTextbox.value, 4)) {
                    WarnBox[1].style.display = "block";
                    return false;
                }
                return true;
            }
        }
        if (document.getElementById("resetpwd-mail-form") && document.getElementById("resetpwd-security-form")) {
            var resetpwdMailForm = document.getElementById("resetpwd-mail-form");
            var resetpwdSecurityForm = document.getElementById("resetpwd-security-form");
            var WarnMailBox = document.getElementById("warn-mail");
            var WarnSecurityBox = document.getElementById("warn-security");
            var codeTextbox = document.getElementById("codetextbox");
            var securityTextbox = document.getElementById("securitytextbox");
            /**
             * 邮箱找回密码表单验证
             * @return {[type]} [description]
             */
            codeTextbox.onchange = function() {
                WarnMailBox.style.display = "none";
                if (!CheckF(this.value, 3) && this.value != "") {
                    WarnMailBox.style.display = "block";
                }
            }
            resetpwdMailForm.onsubmit = function() {
                    WarnMailBox.style.display = "none";
                    if (!CheckF(codeTextbox.value, 3)) {
                        WarnMailBox.style.display = "block";
                        return false;
                    }
                    return true;
                }
                /**
                 * 密保找回密码表单验证
                 * @return {[type]} [description]
                 */
            resetpwdSecurityForm.onsubmit = function() {
                WarnSecurityBox.style.display = "none";
                if (securityTextbox.value == "") {
                    WarnSecurityBox.style.display = "block";
                    return false;
                }
                return true;
            }
        }
        if (document.getElementById("resetpwd-reset-form")) {
            var resetpwdResetForm = document.getElementById("resetpwd-reset-form");
            var resetpwdResetPWDbox = document.getElementsByClassName("resetpwd-reset-password");;
            var WarnBox = document.getElementsByClassName("warn");
            resetpwdResetPWDbox[0].onchange = function() {
                WarnBox[0].style.display = "none";
                WarnBox[1].style.display = "none";
                if (!CheckF(this.value, 2) && this.value != "") {
                    WarnBox[0].style.display = "block";
                }
                if (resetpwdResetPWDbox[1].value != "" && resetpwdResetPWDbox[0].value != resetpwdResetPWDbox[1].value) {
                    WarnBox[1].style.display = "block";
                }
            }
            resetpwdResetPWDbox[1].onchange = function() {
                WarnBox[1].style.display = "none";
                if (resetpwdResetPWDbox[0].value != resetpwdResetPWDbox[1].value && this.value != "") {
                    WarnBox[1].style.display = "block";
                }
            }
            resetpwdResetForm.onsubmit = function() {
                if (!CheckF(resetpwdResetPWDbox[0].value, 2)) {
                    WarnBox[0].style.display = "block";
                    return false;
                }
                if (resetpwdResetPWDbox[0].value != resetpwdResetPWDbox[1].value) {
                    WarnBox[1].style.display = "block";
                    return false;
                }
                return true;
            }
        }
    }
    /**
     * 修改密码表单验证
     */
    if (document.getElementById("modifypwd-form")) {
        var modifypwdForm = document.getElementById("modifypwd-form");
        var modifypwdPWDbox = document.getElementsByClassName("modifypwd-password");
        var WarnBox = document.getElementsByClassName("warn");
        modifypwdPWDbox[0].onchange = function() {
            WarnBox[0].style.display = "none";
            if (!CheckF(this.value, 2) && this.value != "") {
                WarnBox[0].style.display = "block";
            }
        }
        modifypwdPWDbox[1].onchange = function() {
            WarnBox[1].style.display = "none";
            WarnBox[2].style.display = "none";
            if (!CheckF(this.value, 2) && this.value != "") {
                WarnBox[1].style.display = "block";
            }
            if (modifypwdPWDbox[2].value != "" && modifypwdPWDbox[1].value != modifypwdPWDbox[2].value) {
                WarnBox[2].style.display = "block";
            }
        }
        modifypwdPWDbox[2].onchange = function() {
            WarnBox[2].style.display = "none";
            if (modifypwdPWDbox[1].value != this.value) {
                WarnBox[2].style.display = "block";
            }
        }
        modifypwdForm.onsubmit = function() {
            for (var i = 0; i < WarnBox.length; i++) {
                WarnBox[i].style.display = "none";
            }
            if (!CheckF(modifypwdPWDbox[0].value, 2)) {
                WarnBox[0].style.display = "block";
                return false;
            }
            if (!CheckF(modifypwdPWDbox[1].value, 2)) {
                WarnBox[1].style.display = "block";
                return false;
            }
            if (modifypwdPWDbox[1].value != modifypwdPWDbox[2].value) {
                WarnBox[2].style.display = "block";
                return false;
            }
            return true;
        }
    }
    /**
     * 密保设置表单验证
     */
    if (document.getElementById("security-form")) {
        var securityForm = document.getElementById("security-form");
        var WarnBox = document.getElementsByClassName("warn");
        var usernameTextbox = document.getElementById("usernametextbox");
        var codeTextbox = document.getElementById("codetextbox");
        var securityQbox = document.getElementById("securityQbox");
        var securityAbox = document.getElementById("securityAbox");
        usernametextbox.onchange = function() {
            WarnBox[0].style.display = "none";
            if (!CheckF(this.value, 1) && this.value != "") {
                WarnBox[0].style.display = "block";
            }
        }
        codeTextbox.onchange = function() {
            WarnBox[1].style.display = "none";
            if (!CheckF(this.value, 3) && this.value != "") {
                WarnBox[1].style.display = "block";
            }
        }
        securityQbox.onchange = function() {
            WarnBox[2].style.display = "none";
            if (this.value == "NULL") {
                WarnBox[2].style.display = "block";
            }
        }
        securityAbox.onchange = function() {
            WarnBox[3].style.display = "none";
            if (this.value == "") {
                WarnBox[3].style.display = "block";
            }
        }
        securityForm.onsubmit = function() {
            for (var i = 0; i < WarnBox.length; i++) {
                WarnBox[i].style.display = "none";
            }
            if (!CheckF(usernametextbox.value, 1)) {
                WarnBox[0].style.display = "block";
                return false;
            }
            if (!CheckF(codeTextbox.value, 3)) {
                WarnBox[1].style.display = "block";
                return false;
            }
            if (securityQbox.value == "NULL") {
                WarnBox[2].style.display = "block";
                return false;
            }
            if (securityAbox.value == "") {
                WarnBox[3].style.display = "block";
                return false;
            }
            return true;
        }
    }
})();