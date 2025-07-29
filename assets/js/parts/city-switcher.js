(function ($) {
    function getCityFromURL() {
        var path = window.location.pathname.split('/').filter(Boolean);
        return path.length > 0 ? path[0] : '';
    }

    var currentCity = getCityFromURL();
    var citySwitcherText = my_ajax_object.switcherCitiesText;

    if (currentCity && my_ajax_object.availableCities.includes(currentCity)) {
        document.cookie = "selected_city=" + currentCity + "; path=/; max-age=" + (60 * 60 * 24 * 30);

        $('.city-dropdown').each(function () {
            var selectedText = $(this).find('.city-option[data-value="' + currentCity + '"]').text();
            $(this).find('.city-selected span').text(selectedText);
        });

    } else {
        document.cookie = "selected_city=; path=/; max-age=0";
        $('.city-dropdown .city-selected span').text(citySwitcherText);
    }

    // Открытие/закрытие дропдауна
    $('.city-dropdown').on('click', function (e) {
        $(this).toggleClass('open');
    });

    // Клик по элементу
    $('.city-option').on('click', function (e) {
        var city = $(this).data('value');
        var dropdown = $(this).closest('.city-dropdown');

        dropdown.find('.city-selected span').text($(this).text());
        dropdown.removeClass('open');

        if (city) {
            document.cookie = "selected_city=" + city + "; path=/; max-age=" + (60 * 60 * 24 * 30);
            window.location.href = '/' + city + '/';
        } else {
            document.cookie = "selected_city=; path=/; max-age=0";
            window.location.href = '/';
        }
    });

    // Закрытие при клике вне
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.city-dropdown').length) {
            $('.city-dropdown').removeClass('open');
        }
    });
})(jQuery);
