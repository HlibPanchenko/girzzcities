(function ($) {
    function getCityFromURL() {
        var path = window.location.pathname.split('/').filter(Boolean);
        return path.length > 0 ? path[0] : '';
    }

    var currentCity = getCityFromURL();

    if (currentCity && my_ajax_object.availableCities.includes(currentCity)) {
        document.cookie = "selected_city=" + currentCity + "; path=/; max-age=" + (60 * 60 * 24 * 30);
        $('#city-dropdown').val(currentCity);
    }

    $('#city-dropdown').on('change', function () {
        var city = $(this).val();
        if (city) {
            document.cookie = "selected_city=" + city + "; path=/; max-age=" + (60 * 60 * 24 * 30);
            window.location.href = '/' + city + '/';
        }
    });
})(jQuery);
