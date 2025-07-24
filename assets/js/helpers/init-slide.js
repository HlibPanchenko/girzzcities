(function($) {
    window.initializeSliders = function() {
        $('.card-sliders').each(function () {
            let sliderId = $(this).attr('id');

            if (!$(this).data('slider-initialized')) {
                const swiper = new Swiper(`#${sliderId}`, {
                    loop: true,
                    slidesPerView: 1,
                    spaceBetween: 0,
                    effect: 'fade',
                    grabCursor: true,
                    mousewheel: true,
                    pagination: {
                        el: `#${sliderId} .swiper-pagination`,
                        clickable: true,
                    },
                    lazy: {
                        loadPrevNext: true,
                    },
                });

                $(this).data('slider-initialized', true);
            }
        });
    }
})(jQuery);
