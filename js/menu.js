(function() {
    //顶部菜单
    var NavbarToggle = document.getElementById("NavbarToggle");
    var Menu = document.getElementById("Menu");
    var MenuToggle = true;
    NavbarToggle.onclick = function() {
        if (window.innerWidth <= 767) {
            if (MenuToggle == true) {
                Menu.style.display = "block";
                MenuToggle = false;
            } else {
                Menu.style.display = "none";
                MenuToggle = true;
            }
        }
    }
    if (document.getElementById("User")) {
        var User = document.getElementById("User");
        //顶部用户头像处点击
        User.onclick = function() {
            if (window.innerWidth <= 767) {
                return false;
            } else {
                return true;
            }
        }
    }
    //底部导航
    var DropButton = document.getElementsByClassName("drop-button");
    var Footerul = document.getElementsByClassName("footer-ul");
    var Toggle = new Array();
    for (var i = 0; i < DropButton.length; i++) {
        DropButton[i].index = i;
        Toggle[i] = true;
        //按钮点击事件
        DropButton[i].onclick = function() {
            FooterulToggle(this.index);
        }
    }
    window.onresize = function() {
        if (window.innerWidth <= 767) {
            for (var i = Footerul.length - 1; i >= 0; i--) {
                Footerul[i].style.display = "none";
                Toggle[i] = true;
            }
            Menu.style.display = "none";
            MenuToggle = true;
        } else {
            for (var i = Footerul.length - 1; i >= 0; i--) {
                Footerul[i].style.display = "block";
                Toggle[i] = false;
            }
            Menu.style.display = "block";
            MenuToggle = false;
        }
    }

    function FooterulToggle(index) {
        if (window.innerWidth <= 767) {
            if (Toggle[index] == true) {
                Footerul[index].style.display = "block";
                Toggle[index] = false;
            } else {
                Footerul[index].style.display = "none";
                Toggle[index] = true;
            }
            for (var i = 0; i < Footerul.length; i++) {
                if (i != index) {
                    Footerul[i].style.display = "none";
                    Toggle[i] = true;
                }
            }
        }
    }
})();