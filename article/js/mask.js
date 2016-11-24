var mask = document.getElementById("mask");
mask.style.zIndex = '999';
mask.onload = function() {
    var close = document.getElementById("close");
    var box = document.getElementById("box");
    var loading = document.getElementById("loading");
    var image = document.getElementById("image");
    loading.style.visibility = "visibility";
    image.style.visibility = "hidden";

    function MaskIMG(image) {
        if (image.complete && image.src != '') {
            image.style.visibility = "hidden";
            image.style.height = "auto";
            image.style.width = "auto";
            if (image.clientWidth > image.clientHeight) {
                image.style.width = box.clientWidth + "px";
                image.style.height = "auto";
                if (image.clientHeight > box.clientHeight) {
                    image.style.height = box.clientHeight + "px";
                    image.style.width = "auto";
                    image.style.left = (box.clientWidth - image.clientWidth) / 2 + "px";
                } else {
                    image.style.left = "0";
                }
                image.style.top = (box.clientHeight - image.clientHeight) / 2 + "px";
            } else {
                image.style.height = box.clientHeight + "px";
                image.style.width = "auto";
                if (image.clientWidth > box.clientWidth) {
                    image.style.width = box.clientWidth + "px";
                    image.style.height = "auto";
                    image.style.top = (box.clientHeight - image.clientHeight) / 2 + "px";
                } else {
                    image.style.top = "0";
                }
                image.style.left = (box.clientWidth - image.clientWidth) / 2 + "px";
            }
            loading.style.visibility = "hidden";
            image.style.visibility = "visible";
        } else {
            image.style.visibility = "hidden";
            loading.style.margin = (-loading.clientHeight / 2) + "px" + "  " + (-loading.clientWidth / 2) + "px";
            loading.style.visibility = "visibility";
        }
        close.style.left = (image.offsetLeft + image.offsetWidth) + "px";
        close.style.top = image.offsetTop + "px";
    }
    //加载中GIF图片居中
    var timer = setInterval(function() {
        if (mask.style.display == "block" && image.style.visibility == "hidden") {
            loading.style.margin = (-loading.clientHeight / 2) + "px" + "  " + (-loading.clientWidth / 2) + "px";
            window.clearInterval(timer);
        }
    }, 40);
    image.addEventListener("load", function() {
        MaskIMG(image);
    }, false);
    window.addEventListener("resize", function() {
        MaskIMG(image);
    }, false);
    close.onclick = function() {
        mask.style.display = "none";
        image.style.visibility = "hidden";
        image.src = "";
        loading.style.visibility = "visible";
    }
}();