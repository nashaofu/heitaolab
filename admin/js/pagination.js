/**
 * 分页插件
 * @param  {[type]} $ [description]
 * @return {[type]}   [description]
 */
(function($) {
    'use strict';
    var pagination = {
            init: function(obj, args) {
                return (function() {
                    pagination.build(obj, args);
                    pagination.bindEvent(obj, args);
                })();
            },
            //生成按钮
            build: function(obj, args) {
                return (function() {
                    obj.empty();
                    if (args.totalPage < args.currentPage) {
                        args.currentPage = args.totalPage;
                    }
                    //上一页
                    if (args.currentPage > 1) {
                        obj.append('<a href="javascript:void(0);" class="prev">上一页</a>');
                    } else {
                        obj.remove('.prev');
                        obj.append('<a href="javascript:void(0);" class="disabled">上一页</a>');
                    }
                    //中间页码
                    if (args.currentPage != 1 && args.currentPage >= 4 && args.totalPage != 4) {
                        obj.append('<a href="javascript:void(0);" class="page">' + 1 + '</a>');
                    }
                    if (args.currentPage - 2 > 2 && args.currentPage <= args.totalPage && args.totalPage > 5) {
                        obj.append('<div>...</div>');
                    }
                    var start = args.currentPage - 2,
                        end = args.currentPage + 2;
                    if ((start > 1 && args.currentPage < 4) || args.currentPage == 1) {
                        end++;
                    }
                    if (args.currentPage > args.totalPage - 4 && args.currentPage >= args.totalPage) {
                        start--;
                    }
                    for (; start <= end; start++) {
                        if (start <= args.totalPage && start >= 1) {
                            if (start != args.currentPage) {
                                obj.append('<a href="javascript:void(0);" class="page">' + start + '</a>');
                            } else {
                                obj.append('<a href="javascript:void(0);" class="currentPage">' + start + '</a>');
                            }
                        }
                    }
                    if (args.currentPage + 2 < args.totalPage - 1 && args.currentPage >= 1 && args.totalPage > 5) {
                        obj.append('<div>...</div>');
                    }
                    if (args.currentPage != args.totalPage && args.currentPage < args.totalPage - 2 && args.totalPage != 4) {
                        obj.append('<a href="javascript:void(0);" class="page">' + args.totalPage + '</a>');
                    }
                    //下一页
                    if (args.currentPage < args.totalPage) {
                        obj.append('<a href="javascript:void(0);" class="next">下一页</a>');
                    } else {
                        obj.remove('.next');
                        obj.append('<a href="javascript:void(0);" class="disabled">下一页</a>');
                    }
                })();
            },
            //绑定事件
            bindEvent: function(obj, args) {
                return (function() {
                    if (args.totalPage < args.currentPage) {
                        args.currentPage = args.totalPage;
                    }
                    obj.on("click", "a.page", function() {
                        var currentPage = parseInt($(this).text());
                        pagination.build(obj, {
                            "currentPage": currentPage,
                            "totalPage": args.totalPage
                        });
                        if (typeof(args.backFn) == "function") {
                            args.backFn(currentPage);
                        }
                    });
                    //上一页
                    obj.on("click", "a.prev", function() {
                        var currentPage = parseInt(obj.children("a.currentPage").text());
                        pagination.build(obj, {
                            "currentPage": currentPage - 1,
                            "totalPage": args.totalPage
                        });
                        if (typeof(args.backFn) == "function") {
                            args.backFn(currentPage - 1);
                        }
                    });
                    //下一页
                    obj.on("click", "a.next", function() {
                        var currentPage = parseInt(obj.children("a.currentPage").text());
                        pagination.build(obj, {
                            "currentPage": currentPage + 1,
                            "totalPage": args.totalPage
                        });
                        if (typeof(args.backFn) == "function") {
                            args.backFn(currentPage + 1);
                        }
                    });
                })();
            }
        }
        //设置默认参数
    $.fn.pagination = function(options) {
        var args = $.extend({
            totalPage: 0,
            currentPage: 1,
            backFn: function() {}
        }, options);
        pagination.init(this, args);
    }
})(jQuery);