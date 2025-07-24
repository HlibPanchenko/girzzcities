(function ($) {
    $(document).ready(function () {
        var swiperThumbs = new Swiper(".model-secondary-swiper--js", {
            loop: true,
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
            breakpoints: {
                0: {
                    direction: 'vertical',
                },
                768: {
                    direction: 'horizontal',
                },
                992: {
                    direction: 'vertical',
                }
            }
        });


        var swiperMain = new Swiper(".model-swiper--js", {
            loop: true,
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: swiperThumbs,
            },
        });

        // Fancybox.bind("[data-fancybox='gallery']", {});
    });
})(jQuery);