(function($) {
    window.handleSearch = function()
    {
        const $input = $(".search input");
        const $options = $(".list label");

        $input.on("input", function () {
            const searchValue = $(this).val().toLowerCase();

            $options.each(function () {
                const optionText = $(this).text().toLowerCase();
                const isVisible = optionText.includes(searchValue);
                $(this).parent().toggle(isVisible);
            });
        });
    }

    window.resetSearch = function(inputSelector, listSelector) {
        const $input = $(inputSelector);
        const $options = $(listSelector).find('label');

        // Показываем все элементы и очищаем поле ввода
        $options.each(function () {
            $(this).parent().show();
        });
        $input.val(""); // Очищаем поле поиска
    };
})(jQuery);