(function($) {
    $(document).ready(function() {
        $('.faq-question').on('click', function() {
            const $faqItem = $(this).closest('.faq-item');

            if ($faqItem.hasClass('active')) {
                if ($(window).width() < 767.98) {
                    $faqItem.removeClass('active');
                }
            } else {
                $('.faq-item').removeClass('active');
                $faqItem.addClass('active');
            }
        });
    });
})(jQuery);
