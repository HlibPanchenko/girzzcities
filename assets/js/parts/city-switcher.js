(function ($) {
    console.log('city');

    $('#city-dropdown').on('change', function () {
        var city = $(this).val();
        console.log('city: ', city);
        if (city) {
            document.cookie = "selected_city=" + city + "; path=/; max-age=" + (60 * 60 * 24 * 30);
            window.location.href = '/' + city + '/';
        }
    });
})(jQuery);
