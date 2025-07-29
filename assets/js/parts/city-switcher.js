(function ($) {
    function getCityFromURL() {
        var path = window.location.pathname.split('/').filter(Boolean);
        return path.length > 0 ? path[0] : '';
    }

    var currentCity = getCityFromURL();

    if (currentCity && my_ajax_object.availableCities.includes(currentCity)) {
        // ✅ Город есть в URL и он валидный
        document.cookie = "selected_city=" + currentCity + "; path=/; max-age=" + (60 * 60 * 24 * 30);
        $('#city-dropdown').val(currentCity);
    } else {
        // ❌ Город отсутствует в URL — сбрасываем куку и селектор
        document.cookie = "selected_city=; path=/; max-age=0";
        $('#city-dropdown').val('');
    }

    $('#city-dropdown').on('change', function () {
        var city = $(this).val();
        if (city) {
            document.cookie = "selected_city=" + city + "; path=/; max-age=" + (60 * 60 * 24 * 30);
            window.location.href = '/' + city + '/';
        } else {
            // Если выбрали пустое значение, очищаем куку и возвращаемся на главную
            document.cookie = "selected_city=; path=/; max-age=0";
            window.location.href = '/';
        }
    });
})(jQuery);
