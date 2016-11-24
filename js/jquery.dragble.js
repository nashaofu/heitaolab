/**
 * 拖拽插件
 * @param  handler   拖拽手柄
 * @param  boundary  拖拽范围
 * @param  drag()    回掉函数
 */
(function($) {
    var dragble = {
        init: function(options) {
            if (typeof(options) == "undefined") {
                throw new Error("未定义对象");
            }
            if (typeof(options.handler) == "undefined") {
                options.handler = options.target;
            }
            if (typeof(options.boundary) == "undefined") {
                options.boundary = $(document.body);
            }
            this.mouseDown(options);
            this.mouseUp(options);
        },
        mouseDown: function(options) {
            var target = options.target;
            var boundary = options.boundary;
            var offset = {};
            options.handler.off("mousedown").on("mousedown", function(e) {
                //防止默认事件发生 
                e.preventDefault();
                if (e.target == this) {
                    offset.x = e.clientX - boundary.position().left - target.position().left;
                    offset.y = e.clientY - boundary.position().top - target.position().top;
                    dragble.mouseMove(options, offset);
                }
            });
        },
        mouseMove: function(options, offset) {
            var target = options.target;
            var boundary = options.boundary;
            var left = 0;
            var top = 0;
            //边框和内边距宽度
            var boxsize = parseInt(target.css("border-width")) + parseInt(target.css("padding"));
            $(window).off("mousemove").on("mousemove", function(e) {
                //防止默认事件发生 
                e.preventDefault();
                left = e.clientX - boundary.position().left - offset.x;
                top = e.clientY - boundary.position().top - offset.y;
                if (left <= boundary.position().left) {
                    left = boundary.position().left;
                }
                if (left > boundary.width() + boundary.position().left - target.width() - boxsize * 2) {
                    left = boundary.width() + boundary.position().left - target.width() - boxsize * 2;
                }
                if (top < boundary.position().top) {
                    top = boundary.position().top;
                }
                if (top > boundary.height() + boundary.position().top - target.height() - boxsize * 2) {
                    top = boundary.height() + boundary.position().top - target.height() - boxsize * 2;
                }
                target.css({
                    left: left,
                    top: top
                });
                var size = {
                    top: (target.position().top - boundary.position().top) + "px",
                    right: (target.position().left + target.width() + boxsize * 2 - boundary.position().left) + "px",
                    bottom: (target.position().top + target.height() + boxsize * 2 - boundary.position().top) + "px",
                    left: (target.position().left - boundary.position().left) + "px"
                };
                options.drag(size);
            });
        },
        mouseUp: function(options) {
            //用window来触发事件，防止不能移除绑定
            $(window).off("mouseup").on("mouseup", function() {
                $(window).off("mousemove");
            });
        }
    }
    $.fn.dragble = function(options) {
        options.target = $(this);
        dragble.init(options);
    }
})(jQuery);