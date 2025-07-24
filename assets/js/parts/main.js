(function ($) {
    let $cur_button = 0;
    let $bef_button = 0;

    $(".rank-math-question").click(function () {
        if ($cur_button !== 0) {
            $bef_button = $cur_button;
            $cur_button = $(this);
        } else {
            $cur_button = $(this);
        }

        if ($(this).next().is(":hidden")) {
            $(".rank-math-answer").slideUp("selected");
            $($bef_button).removeClass("clicked");
            $(this).addClass("clicked");
            $(this).next().slideDown("selected");
        } else {
            $(this).next().slideUp("selected");
            $(this).removeClass("clicked");
        }
    });

    $(".filter-show").click(function () {
        $(".filter-list").toggleClass("filter-list--active");
    });

    $('.lazyload').Lazy({
        threshold: 100,
        effect: 'fadeIn',
        placeholder: '',
        afterLoad: function (element) {
            $(".image-placeholder").attr('style', 'display: none;');
        }
    });
})(jQuery);
