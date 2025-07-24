(function ($) {
    $(document).ready(function () {

        // Логика для табов с классом .info-tabs
        function initInfoTabs() {
            $(".info-tabs .tab-content").hide().first().show();
            $(".info-tabs .item").first().addClass("active");

            $(".info-tabs .item").on("click", function () {
                var tabName = $(this).data("tab");
                $(".info-tabs .item").removeClass("active");
                $(this).addClass("active");

                $(".info-tabs .tab-content").hide();
                $("." + tabName).show();
            });
        }

        // Логика для табов с классом .tabs
        function initTabs() {
            $(".tabs .item").first().addClass("active");
            // $(".content .content-tab").hide();
            $(".content .content-tab").hide().first().show();

            $(".tabs .item").on("click", function () {
                var tabId = $(this).data("tab");
                console.log('tabId: ', tabId);
                // Убираем активность у всех вкладок
                $(".tabs .item").removeClass("active");
                $(this).addClass("active");

                // Скрываем все контентные блоки
                $(".content .content-tab").hide();

                // Показываем соответствующий контент
                $("." + tabId).show();
            });
        }

        // Инициализация обеих логик
        initInfoTabs();
        initTabs();

    });
})(jQuery);
