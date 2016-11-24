var $select = $("#file-avatar");
var $cropper = $(".cropper");
var $img = $(".cropper-img");
var $mask = $(".cropper-mask")
var $handlebg = $(".cropper-handle-bg");
var $handle = $(".cropper-handle");
$(document).ready(function() {
    //裁剪框大小初始化
    $cropper.height($cropper.width());
    //打开文件读取图片
    if (typeof(FileReader) === "undefined") {
        alert("抱歉，你的浏览器不支持 FileReader，请使用现代浏览器操作！");
        $select.setAttribute("disabled", "disabled");
    } else {
        $select.change(function() {
            var file = this.files[0];
            if (!file) {
                return false;
            }
            // 添加图片加载完成事件
            $img.load(function() {
                sizeset($img, function() {
                    // 遮罩层图片加载完成事件
                    $handlebg.load(function() {
                        sizeset($handlebg, function() {
                            //手柄设置
                            handleset($handle, $handlebg)
                        });
                    });
                });
            });
            if (file.size <= 5242880) {
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function() {
                    if ((/^image[/]((jpe?g)|(png)|(gif))$/i).test(file.type)) {
                        $img.attr("src", this.result);
                        $handlebg.attr("src", this.result);
                        $mask.css({
                            visibility: "visible"
                        });
                    } else {
                        alert("图片不是jpg、png、gif格式的！");
                    }
                }
            } else {
                alert("文件大于了5M！");
            }
        });
    }
    //初始化默认图片
    $img.load(function() {
        sizeset($img);
    });
    //裁剪按钮点击事件
    $("#avatar-upload-form").submit(function() {
        if (!$select[0].files[0]) {
            alert("请选择图片！");
            return false;
        }
        //边框和内边距
        var boxsize = parseInt($handle.css("border-width")) + parseInt($handle.css("padding"));
        var cropper = {
            img: {
                width: $img.width(),
                height: $img.height(),
                left: $img.position().left,
                top: $img.position().top,
            },
            mask: {
                width: $handle.width() + boxsize * 2,
                height: $handle.height() + boxsize * 2,
                left: $handle.position().left,
                top: $handle.position().top,
            }
        }
        var data = ["iw" + "=" + cropper.img.width, "ih" + "=" + cropper.img.height, "mw" + "=" + cropper.mask.width, "mh" + "=" + cropper.mask.height, "ml" + "=" + (cropper.mask.left - cropper.img.left), "mt" + "=" + (cropper.mask.top - cropper.img.top), ].join(",")
        $("#avatar-data").val(data);
    });
});
$(window).resize(function() {
    width = $(".cropper-container").width();
    $cropper.width(width);
    $cropper.height(width);
    sizeset($img, function() {
        // 遮罩层图片加载完成事件
        sizeset($handlebg, function() {
            //手柄设置
            if ($handle.css("visibility") === "visible") {
                handleset($handle, $handlebg)
            }
        });
    });
});
//改变元素大小
$('.cropper-handle').resizeble({
    boundary: $(".cropper-img"),
    handler: $('.cropper-handle-zoom'),
    min: {
        width: 40,
        height: 40
    },
    resize: function(size) {
        var clip = [("rect(" + size.top), size.right, size.bottom, (size.left + ")")].join(",");
        $(".cropper-handle-bg").css({
            clip: clip
        });
    }
});
// 拖动元素位置
$('.cropper-handle').dragble({
    boundary: $(".cropper-img"),
    drag: function(size) {
        var clip = [("rect(" + size.top), size.right, size.bottom, (size.left + ")")].join(",");
        $(".cropper-handle-bg").css({
            clip: clip
        });
    }
});
/**
 
 * 图片大小初始化
 
 * @return {[type]} [description]
 
 */
function sizeset($img, callback) {
    $img.css({
        visibility: "hidden",
        width: "auto",
        height: "auto"
    });
    if ($img.width() > $img.height()) {
        $img.css({
            height: "auto",
            width: "100%"
        });
        $img.css({
            top: Math.round(($img.width() - $img.height()) / 2) + "px",
            left: 0
        });
    } else {
        $img.css({
            width: "auto",
            height: "100%"
        });
        $img.css({
            top: 0,
            left: Math.round(($img.height() - $img.width()) / 2) + "px"
        });
    }
    $img.css({
        visibility: "visible",
    });
    if (typeof(callback) != "undefined") {
        callback();
    }
}

function handleset($handle, $handlebg) {
    //边框和内边距
    var boxsize = parseInt($handle.css("border-width")) + parseInt($handle.css("padding"));
    //先设置宽高
    $handle.css({
        visibility: "visible",
        width: Math.min($handlebg.width() / 2, $handlebg.height() / 2) - boxsize * 2,
        height: Math.min($handlebg.width() / 2, $handlebg.height() / 2) - boxsize * 2
    });
    //获取宽高设置位置
    $handle.css({
        left: $handlebg.position().left + ($handlebg.width() - $handle.width()) / 2 - boxsize,
        top: $handlebg.position().top + ($handlebg.height() - $handle.height()) / 2 - boxsize
    });
    var size = {
        top: ($handle.position().top - $handlebg.position().top) + "px",
        right: ($handle.position().left + $handle.width() + boxsize * 2 - $handlebg.position().left) + "px",
        bottom: ($handle.position().top + $handle.height() + boxsize * 2 - $handlebg.position().top) + "px",
        left: ($handle.position().left - $handlebg.position().left) + "px"
    };
    var clip = [("rect(" + size.top), size.right, size.bottom, (size.left + ")")].join(",");
    $handlebg.css({
        clip: clip
    });
}