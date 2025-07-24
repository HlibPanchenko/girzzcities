(function ($) {
    $(document).ready(function () {
        const tabBlock = $('.filter .tabs');
        const tabButtons = $('.filter .tab-button');
        const tabContents = $('.filter .tab-content');

        function closeTabs() {
            tabBlock.removeClass('active');
            tabButtons.removeClass('active');
            tabContents.removeClass('active');
            resetSearch('.search input', '.list');
        }

        tabButtons.on('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            console.log('click');
            const tabId = $(this).data('tab');
            const isActive = $(this).hasClass('active');

            if (isActive) {
                closeTabs();
                return;
            }

            closeTabs();
            tabBlock.addClass('active');

            $(this).addClass('active');
            $('#' + tabId).addClass('active');
        });

        $(document).on('click', function () {
            closeTabs();
        });

        $('.tabs-content').on('click', function (event) {
            event.stopPropagation();
        });
    });
})(jQuery);
