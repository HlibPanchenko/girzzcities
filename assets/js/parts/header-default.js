(function ($) {
    $(document).ready(function () {
        if (!$('.header--default').length) return;

        // Для мобильной версии
        if ($(window).width() < 992) {
            // Обработчик клика на svg
            $('.menu-link-wrapper svg').on('click', function () {
                var $subMenu = $(this).closest('.menu-link-wrapper').next('.sub-menu');
                $subMenu.toggleClass('opened');
            });
        }

        // Обработчик для бургер-меню
        $('.burger').on('click', function () {
            $('.header-default--mobile').toggleClass('opened');

            if ($('.header-default--mobile').hasClass('opened')) {
                $('body').css('overflow', 'hidden');
            } else {
                $('body').css('overflow', '');
            }
        });
    });
})(jQuery);
