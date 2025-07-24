(function ($) {
    let popup = $('.popup');
    if (popup.length) {
        setTimeout(function () {
            if (getCookie('popupShown') === 'true') {
                return;
            }

            let popup = $('.popup');
            let closeButton = popup.find('.popup-close');

            popup.show();

            closeButton.on('click', function () {
                popup.hide();
                setCookie('popupShown', 'true', 60);
            });
        }, popup_delay);
    }
})(jQuery);
