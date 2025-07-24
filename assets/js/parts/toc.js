(function ($) {
    $(document).ready(function () {
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                const tocLink = $('.toc-link[href="#' + entry.target.id + '"]');

                if (entry.isIntersecting) {
                    tocLink.addClass('active');
                } else {
                    tocLink.removeClass('active');
                }
            });
        }, { threshold: 1 });

        $('h1, h2, h3').each(function () {
            // observer.observe(this);
        });

        $('.toc-link').on('click', function (e) {
            e.preventDefault();
            var targetId = $(this).attr('href'); // Получаем ID цели
            $('html, body').animate({
                scrollTop: $(targetId).offset().top
            }, 300);
        });
    });
})(jQuery);
