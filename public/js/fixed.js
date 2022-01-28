$(function () {
    //navバー,スクロール処理
    var $win = $(window),
        $header = $("header"),
        headerPos = $header.offset().top,
        fixedClass = "fixed";

    $win.on("load scroll", function () {
        var value = $(this).scrollTop();
        if (value > headerPos) {
            $header.addClass(fixedClass);
        } else {
            $header.removeClass(fixedClass);
        }
    });
});
