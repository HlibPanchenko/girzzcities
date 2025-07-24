(function ($) {
    $(document).ready(() => {
        const contactItems = $('.contact-item');

        contactItems.on('click', function() {
            contactItems.removeClass('active');
            $(this).addClass('active');
            console.log(this)
        });
    });
})(jQuery);