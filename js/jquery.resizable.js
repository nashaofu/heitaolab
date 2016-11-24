/**
 * 改变元素大小插件
 * @param  boundary   大小边界
 * @param  handler    拖拽手柄
 * @param  min        最小值
 * @param  min        最大值
 * @param  resize     大小改变时的回掉函数
 */
(function($) {
    var resizeble = {
        init: function(options) {
            if (typeof(options) == "undefined") {
                throw new Error("未定义对象");
            }
            if (typeof(options.boundary) == "undefined") {
                options.boundary = $(document.body);
            }
            if (typeof(options.handler) == "undefined") {
                throw new Error("未定义手柄");
            }
            if (typeof(options.min) == "object") {
                options.target.css({
                    "min-width": options.min.width + "px",
                    "min-height": options.min.height + "px"
                });
            }
            if (typeof(options.max) == "object") {
                options.target.css({
                    "max-width": options.max.width + "px",
                    "max-height": options.max.height + "px"
                });
            }
            this.mouseDown(options);
            this.mouseUp(options);
        },
        mouseDown: function(options) {
            options.handler.off("mousedown").on("mousedown", function(e) {
                //防止默认事件发生 
                e.preventDefault();
                resizeble.mouseMove(options);
            });
        },
        mouseMove: function(options) {
            var target = options.target;
            var boundary = options.boundary;
            var width = 0;
            var height = 0;
            //边框和内边距宽度
            var boxsize = parseInt(target.css("border-width")) + parseInt(target.css("padding"));
            $(window).off("mousemove").on("mousemove", function(e) {
                e.preventDefault();
                width = e.clientX - target.offset().left;
                height = e.clientY - target.offset().top;
                width = height = Math.max(width, height);
                if (width <= 0) {
                    width = 0;
                }
                if (width >= boundary.offset().left - target.offset().left + boundary.width() - boxsize * 2) {
                    width = boundary.offset().left - target.offset().left + boundary.width() - boxsize * 2;
                }
                if (height <= 0) {
                    height = 0;
                }
                if (height >= boundary.offset().top - target.offset().top + boundary.height() - boxsize * 2) {
                    height = boundary.offset().top - target.offset().top + boundary.height() - boxsize * 2;
                }
                width = height = Math.min(width, height);
                target.css({
                    width: width,
                    height: height
                });
                var size = {
                    top: (target.offset().top - boundary.offset().top) + "px",
                    right: (target.offset().left + target.width() + boxsize * 2 - boundary.offset().left) + "px",
                    bottom: (target.offset().top + target.height() + boxsize * 2 - boundary.offset().top) + "px",
                    left: (target.offset().left - boundary.offset().left) + "px"
                };
                options.resize(size);
            });
        },
        mouseUp: function(options) {
            $(window).off("mouseup").on("mouseup", function() {
                $(window).off("mousemove");
            });
        }
    }
    $.fn.resizeble = function(options) {
        options.target = $(this);
        resizeble.init(options);
    }
})(jQuery);