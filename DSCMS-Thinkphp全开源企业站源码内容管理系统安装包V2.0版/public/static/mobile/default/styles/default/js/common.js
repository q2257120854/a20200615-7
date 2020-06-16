$(function () {
    $(".ds-home-header").on("click", ".nav-bar",
            function () {
                if ($(".ds-home-header .mc").hasClass("show")) {
                    $(".ds-home-header .mc").removeClass("show")
                } else {
                    $(".ds-home-header .mc").addClass("show")
                }
            });
});