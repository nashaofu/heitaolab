(function($) {
    var upload = {
        init: function(obj, src, title) {
            var background = document.createElement('div');
            var box = document.createElement('div');
            var bar = document.createElement('div');
            var boxtitle = document.createElement('div');
            var closebtn = document.createElement('a');
            var toolbar = document.createElement('div');
            var toolbarbtn = document.createElement('a');
            var container = document.createElement('div');
            var iframe = document.createElement('iframe');
            var footer = document.createElement('div');
            //设置样式
            this.setStyle(background, box, bar, boxtitle, closebtn, toolbar, toolbarbtn, container, iframe, footer);
            boxtitle.appendChild(document.createTextNode(title));
            closebtn.appendChild(document.createTextNode('X'));
            closebtn.title = '关闭窗口';
            closebtn.id = 'closebtn';
            closebtn.href = 'javascript:void(0)';
            background.id = 'background';
            iframe.src = src;
            iframe.name = 'targetFrame';
            bar.appendChild(boxtitle);
            bar.appendChild(closebtn);
            box.appendChild(bar);
            toolbarbtn.appendChild(document.createTextNode('上传轮播图片'));
            toolbar.appendChild(toolbarbtn);
            box.appendChild(toolbar);
            box.appendChild(container);
            box.appendChild(footer);
            container.appendChild(iframe);
            background.appendChild(box);
            obj.append(background);
            this.bindEvent(obj);
        },
        setStyle: function(background, box, bar, boxtitle, closebtn, toolbar, toolbarbtn, container, iframe, footer) {
            var backgroundstyle = '';
            var boxstyle = '';
            var barstyle = '';
            var boxtitlestyle = '';
            var closebtnstyle = '';
            var toolbarstyle = '';
            var toolbarbtnstyle = '';
            var containerstyle = '';
            var iframestyle = '';
            var footerstyle = '';
            for (var style in this.style.background) {
                backgroundstyle += style + ':' + this.style.background[style] + ';';
            }
            for (var style in this.style.box) {
                boxstyle += style + ':' + this.style.box[style] + ';';
            }
            for (var style in this.style.bar) {
                barstyle += style + ':' + this.style.bar[style] + ';';
            }
            for (var style in this.style.boxtitle) {
                boxtitlestyle += style + ':' + this.style.boxtitle[style] + ';';
            }
            for (var style in this.style.closebtn) {
                closebtnstyle += style + ':' + this.style.closebtn[style] + ';';
            }
            for (var style in this.style.container) {
                containerstyle += style + ':' + this.style.container[style] + ';';
            }
            for (var style in this.style.iframe) {
                iframestyle += style + ':' + this.style.iframe[style] + ';';
            }
            for (var style in this.style.footer) {
                footerstyle += style + ':' + this.style.footer[style] + ';';
            }
            for (var style in this.style.toolbar) {
                toolbarstyle += style + ':' + this.style.toolbar[style] + ';';
            }
            for (var style in this.style.toolbarbtn) {
                toolbarbtnstyle += style + ':' + this.style.toolbarbtn[style] + ';';
            }
            background.setAttribute('style', backgroundstyle);
            box.setAttribute('style', boxstyle);
            bar.setAttribute('style', barstyle);
            boxtitle.setAttribute('style', boxtitlestyle);
            closebtn.setAttribute('style', closebtnstyle);
            toolbar.setAttribute('style', toolbarstyle);
            toolbarbtn.setAttribute('style', toolbarbtnstyle);
            container.setAttribute('style', containerstyle);
            iframe.setAttribute('style', iframestyle);
            footer.setAttribute('style', footerstyle);
        },
        style: {
            background: {
                width: '100%',
                height: '100%',
                position: 'fixed',
                top: 0,
                left: 0,
                'background-color': 'rgba(255,255,255,0.4)'
            },
            box: {
                width: '300px',
                height: '400px',
                margin: '-200px -150px',
                position: 'absolute',
                top: '50%',
                left: '50%',
                background: '#fff',
                border: 'none',
                resize: 'none',
                overflow: 'hidden',
                'border-radius': '5px'
            },
            bar: {
                width: '100%',
                height: '40px',
                'line-height': '40px;',
                'background-color': 'rgb(207, 209, 207)',
                'background-image': 'linear-gradient(to bottom, #f5f5f5, #cfd1cf)',
                'border-radius': '4px 4px 0 0',
                'border-bottom': '1px solid #aaa',
                'text-align': 'left'
            },
            boxtitle: {
                width: 'auto',
                height: '30px',
                'line-height': '30px;',
                display: 'block',
                padding: '5px 50px 5px 7px',
                overflow: 'hidden',
                'text-overflow': 'ellipsis',
                'font-size': '16px',
                'font-family': 'Microsoft Yahei, Arial, Helvetica, Tahoma, Verdana, sans-serif'
            },
            closebtn: {
                width: '30px',
                height: '30px',
                'line-height': '30px',
                margin: '-40px 0 0 0',
                padding: '5px',
                float: 'right',
                color: '#000',
                'text-decoration': 'none',
                'text-align': 'center',
                'font-size': '20px',
                'font-family': 'Arial, Helvetica, Tahoma, Verdana, sans-serif'
            },
            toolbar: {
                width: '100%',
                height: '36px',
                'background-color': '#eee',
                display: 'block',
                'border-bottom': '1px solid #cacaca'
            },
            toolbarbtn: {
                width: '120px',
                height: '30px',
                'line-height': '30px',
                margin: '4px 0 0 6px',
                display: 'block',
                float: 'left',
                color: '#000',
                'background-color': '#eee',
                'background-image': 'linear-gradient(to bottom, #fafafa, #ededed)',
                border: '1px solid #cacaca',
                'border-bottom': 'none',
                'border-radius': '3px 3px 0 0',
                'border-collapse': 'collapse',
                'text-decoration': 'none',
                'text-align': 'center',
                'font-size': '15px',
                'font-family': 'Arial, Helvetica, Tahoma, Verdana, sans-serif',
                cursor: 'pointer'
            },
            container: {
                width: 'auto',
                height: 'auto',
                display: 'block',
                padding: '0 20px',
                overflow: 'hidden',
                position: 'absolute',
                top: '76px',
                bottom: '40px',
                left: 0,
                right: 0
            },
            iframe: {
                width: '100%',
                height: '100%',
                display: 'block',
                border: 'none',
                resize: 'none',
                'overflow': 'hidden'
            },
            footer: {
                width: '100%',
                height: '40px',
                'line-height': '40px;',
                display: 'block',
                padding: 0,
                overflow: 'hidden',
                position: 'absolute',
                bottom: 0,
                left: 0,
                'background-color': 'rgb(207, 209, 207)',
                'background-image': 'linear-gradient(to bottom, #f5f5f5, #cfd1cf)',
                'border-radius': '0 0 4px 4px',
                'border-top': '1px solid #eee'
            }
        },
        bindEvent: function(obj) {
            return (function() {
                obj.on('click', '#closebtn', function() {
                    obj.children('#background').remove();
                });
                obj.on('mouseover mouseout', '#closebtn', function(e) {
                    if (e.type == 'mouseover') {
                        obj.find('#closebtn').css('color', '#777');
                    }
                    if (e.type == 'mouseout') {
                        obj.find('#closebtn').css('color', '#000');
                    }
                });
            })();
        }
    }
    $.fn.upload = function(src, title) {
        upload.init(this, src, title)
    }
})(jQuery);