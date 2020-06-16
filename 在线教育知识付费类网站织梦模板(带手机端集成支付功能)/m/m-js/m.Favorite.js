var Bitauto = Bitauto || {};
Bitauto.News = (function (jQuery) {

  //初始化新闻评价
    function NewsEstimateInit() {
        if (newsId != undefined && newsId != null && newsId != "") {
            var times = getCookie();
            jQuery.ajax({
                success: function (data) {
                    var d = jQuery.parseJSON(data);
                    if (d != null) {
                        $(".ico-zan a").append(d.Support);
                        $(".ico-cai a").append(d.Tread);
                    }
                }
            });



            if (times != null) {
                $(".ico-zan ").removeClass().addClass("ico-zan ico-zan-gray");
                $(".ico-cai ").removeClass().addClass("ico-cai ico-cai-gray");
               
            }
            else {
                jQuery(".ico-zan").bind("click", function () {
                    NewsEstimate(1);
                });
                jQuery(".ico-cai").bind("click", function () {
                    NewsEstimate(2);
                });
            }
        }
    }
  
})(jQuery);