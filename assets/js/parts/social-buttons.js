(function ($) {
    function handlerMobileButton() {
        if (window.innerWidth <= 768) {
            const $socialButton = $('.social-button.links');

            $socialButton.on('click', function () {
                $(this).toggleClass('active');
            });
        }
    }

    $(document).ready(function () {
        handlerMobileButton();
    });

    $(document).on('ajaxComplete', function () {
        handlerMobileButton();
    });
})(jQuery);
