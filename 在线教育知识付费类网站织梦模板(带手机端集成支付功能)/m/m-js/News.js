Bitauto.WapNews = (function (jQuery) {
    return {
        InitPage: function () {
            $('[data-action=popup-share]').rightSwipe({
                clickEnd: function (b) {
                    var $leftPopup = this;
                    if (b) {
                        var $back = $('.' + $leftPopup.attr('data-back'))
                        $back.touches({ touchstart: function (ev) { ev.preventDefault(); }, touchmove: function (ev) { ev.preventDefault(); } });
                        $leftPopup.find('.close').on('click', function (ev) {
                            ev.preventDefault();
                            $back.trigger('close');
                        })
                    }
                }
            })

           
        },



        // 目录
        catalogSwipe: function () {
            $('[data-action=popup-catalog]').rightSwipe({
                clickEnd: function (b) {
                    var $leftPopup = this;
                    if (b) {
                        $("#cataLogPopup").show();
                        var $back = $('.' + $leftPopup.attr('data-back'))
                        $back.touches({ touchstart: function (ev) { ev.preventDefault(); }, touchmove: function (ev) { ev.preventDefault(); } });
                        $leftPopup.find('.close').on('click', function (ev) {
                            ev.preventDefault();
                            $back.trigger('close');
                        })

                    }
                }
            }) // 目录提示
        },


      
    }
})(jQuery);

Bitauto.WapNews.InitPage();
$('#catalogMask').bind("click", function () {
    $(this).hide();
    $("#cataLogPopup").hide();
    $('body').css('overflow', 'visible');
});