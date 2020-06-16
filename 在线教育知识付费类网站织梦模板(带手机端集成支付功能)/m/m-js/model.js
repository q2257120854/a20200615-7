/*
开发者：王亮
功能:仿jquery类库（功能强大，可扩展）
时间:2014.5.5
*/

/*默认值*/
Object.extend = function (destination, source) {
    if (!destination) return source;
    for (var property in source) {
        if (!destination[property]) {
            destination[property] = source[property];
        }
    }
    return destination;
}

//屏幕旋转完成事件(横屏:horizontal|竖屏:vertical)
$.rotateEnd = function (fn) {
    function toResize() {
        var winW = document.documentElement.clientWidth,
           winH = document.documentElement.clientHeight;
        setTimeout(function () { fn && fn(winW > winH ? "horizontal" : "vertical"); }, 200);
    }
    $(window).resize(toResize).trigger('resize');
};

var classNames = ['Webkit', 'ms', 'Moz', 'O', ''];
var eventNames = ['webkit', 'moz', 'o'];
(function ($) {
    //添加css3样式
    $.fn.addClass3 = function (name, value) {
        var o = this[0];
        var cName = name.charAt(0).toUpperCase() + name.substring(1);
        for (var i = 0; i < classNames.length; i++) {
            o.style[classNames[i] + cName] = value;
        }
        return $(o);
    }





    //transition事件监听
    $.fn.transitionEnd = function (options) {
        var setting = {
            listen: 'TransitionEnd',
            end: null
        }
        options = Object.extend(options, setting);
        var $this = this;
        function seatTransitionEnd() {
            for (var i = 0; i < eventNames.length; i++) {
                if (eventNames[i] == 'moz') {
                    $this.removeEvent(options.listen.toLocaleLowerCase(), seatTransitionEnd);
                } else {
                    $this.removeEvent(eventNames[i] + options.listen, seatTransitionEnd);
                }
            }
            options.end && options.end.call($this);
        }
        for (var i = 0; i < eventNames.length; i++) {
            if (eventNames[i] == 'moz') {
                $this.addEvent(options.listen.toLocaleLowerCase(), seatTransitionEnd);
            } else {
                $this.addEvent(eventNames[i] + options.listen, seatTransitionEnd);
            }
        }
    }






    //添加事件
    $.fn.addEvent = function (name, fn) {
        var obj = this[0];
        var cName = name.charAt(0).toUpperCase() + name.substring(1);
        for (var i = 0; i < eventNames.length; i++) {
            obj.addEventListener(eventNames[i] + cName, fn, false);
        }
        obj.addEventListener(name.charAt(0).toLowerCase() + name.substring(1), fn, false);
    }

    //删除事件
    $.fn.removeEvent = function (name, fn) {
        var obj = this[0];
        var cName = name.charAt(0).toUpperCase() + name.substring(1);
        for (var i = 0; i < eventNames.length; i++) {
            obj.removeEventListener(eventNames[i] + cName, fn, false);
        }
        obj.removeEventListener(name.charAt(0).toLowerCase() + name.substring(1), fn, false);
    }

    $.fn.offsetHeight = function () {
        return this.height() + parseInt(this.css('padding-top')) + parseInt(this.css('padding-bottom')) + parseInt(this.css('margin-top')) + parseInt(this.css('margin-bottom'));
    }



    //触摸屏事件
    $.fn.touches = function (options) {
        var setting = {
            init: null,//初始化
            touchstart: null,  //按下
            touchmove: null, //滑动
            touchend: null //抬起
        };
        options = Object.extend(options, setting);
        var $this = this, touchesDiv = $this[0];
        if (!$this[0]) return;
        touchesDiv.addEventListener('touchstart', function (ev) {
            options.touchstart && options.touchstart.call($this, ev);

            function fnMove(ev) {

                options.touchmove && options.touchmove.call($this, ev);
            }

            function fnEnd(ev) {
                options.touchend && options.touchend.call($this, ev);
                document.removeEventListener('touchmove', fnMove, false);
                document.removeEventListener('touchend', fnEnd, false);
            }
            document.addEventListener('touchmove', fnMove, false);
            document.addEventListener('touchend', fnEnd, false);
            return false;
        }, false)
        options.init && options.init.call($this);
    }


    //右侧弹出层
    $.fn.rightSwipeAction = function (options) {
        var setting = {
            show: 'swipeLeft-block',
            clickEnd: null
        };
        options = Object.extend(options, setting);
        var $child = $(this.children(1)), display = 'none';
        if ($child.hasClass(options.show)) {
            display = 'none';
        } else {
            display = 'block';
        }
        options.clickEnd && options.clickEnd.call($child, display);
    };

    //右侧附加选择层插件
    $.fn.rightSwipe = function (options) {
        var $temp = null;
        var setting = {
            isclick: null,
            swip: '.swipeLeft',
            clickEnd: null //打开关闭层回调事件
        };
        options = Object.extend(options, setting);
        this.each(function (index, curr) {
            var $curr = $(curr);
            (function ($this) {
                $this.isclick = true;
                $this.click(function (ev) {
                    ev.preventDefault();
                    options.isclick && ($this.isclick = options.isclick.call($this));
                    if ($this.isclick == false) {
                        return;
                    }
                    var $leftPopup = $('.leftPopup.' + $this.attr('data-action'));
                    $leftPopup[0].style.zIndex = 999999;
                    $leftPopup.rightSwipeAction({
                        clickEnd: function (display) {
                            var $back = $('.' + $leftPopup.attr('data-back')),
                                $swipeLeft = $leftPopup.find(options.swip);
                            $leftPopup[0].style.display = $back[0].style.display = '';
                            $back[0].style.zIndex = 699999;
                            if ($temp && $temp.length > 0) {
                                $temp.removeClass('swipeLeft-block');
                                $back[0].style.display = 'none';
                            }
                            setTimeout(function () {
                                $swipeLeft.addClass('swipeLeft-block');
                            }, 100)
                            $temp = $swipeLeft;

                            $back.on('close', function () {
                                if ($temp[0])
                                    $temp.removeClass('swipeLeft-block');
                                setTimeout(function () {
                                    if ($temp && $temp.length > 0) {
                                        $leftPopup[0].style.display = $('.' + $temp.parent().attr('data-back'))[0].style.display = 'none';
                                        $temp = null;
                                        options.clickEnd && options.clickEnd.call($leftPopup, false);
                                    }
                                }, 300)

                            })

                            $back.touches({
                                touchstart: function () {
                                    $back.trigger('close');
                                }
                            })
                            $swipeLeft.transitionEnd({ end: function () { options.clickEnd && options.clickEnd.call($leftPopup, true); } })
                        }
                    });
                })
            })($curr);
        })
    }

})(jQuery);