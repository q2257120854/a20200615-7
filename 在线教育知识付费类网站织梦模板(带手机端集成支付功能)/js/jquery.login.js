; (function ($) {
    $.extend({
        "login": function (loginBtn) {
            if ($(loginBtn).length === 0) { alert('找不到登录按钮，请检查按钮是否填写正确。'); return false; }
            var $win = $(window), $loginDiv = $('#_login_div_quick_'), $login = $('#login_button'), $errTip = $('#error_tips'), $capsLock = $('#caps_lock_tips'), showLogin = function () {
                $loginDiv.css({
                    top: ($win.height() - $loginDiv.height()) / 2 + 'px',
                    left: ($win.width() - $loginDiv.width()) / 2 + 'px',
                    display: 'block'
                });
            },

            $userTip = $('#uin_tips'), $passTip = $('#pwd_tips'), $operateTip = $('#operate_tips'), $delUserInput = $('#uin_del'), $u = $('#u'), $p = $('#p'), $switch = $('#qrswitch_logo'), $qr = $('#web_qr_login_show');
            $(loginBtn).click(function () { showLogin(); });
            $win.resize(function () { if ($loginDiv.is(':visible')) { showLogin(); } });
            $('#close').click(function () { $loginDiv.hide(); });
            $u.add($p).bind({
                'focus': function () {
                    var $this = $(this), $currTip = $this.attr('id') === 'u' ? ($operateTip.show(), $userTip) : $passTip;
                    $this.parent().css('background-position-y', '-45px');
                    $currTip.css('color', '#ddd');
                },
                
                'input': function (e) {
                    var $this = $(this), $currTip = $this.attr('id') === 'u' ? $userTip : $passTip;
                    if ($this.val()) {
                        if ($currTip.is(':visible')) {
                            $currTip.hide();
                            if ($currTip === $userTip) { $delUserInput.show(); }
                        }
                    } else {
                        $currTip.show();
                        if ($currTip === $userTip) { $delUserInput.hide(); }
                    }
                }
            });
           

        }
    });
}(jQuery));