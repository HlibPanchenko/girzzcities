(function ($) {
    function updateDropdownHeight() {
        const windowWidth = window.innerWidth;
        console.log('=== updateDropdownHeight ===');

        if (windowWidth <= 767.98) {
            const $headerBanner = $('.header-banner');
            const $headerMiddle = $('.header-middle');
            const $headerBottom = $('.header-bottom--mobile');
            const $dropdownRow = $('.header-bottom--mobile .dropdown__row');
            const $wpAdminBar = $('#wpadminbar');

            if ($headerBottom.length && $dropdownRow.length) {
                const viewportHeight = window.visualViewport?.height || window.innerHeight;
                console.log('viewportHeight:', viewportHeight);

                let offset = 0;

                if ($wpAdminBar.length) {
                    const height = $wpAdminBar.outerHeight();
                    console.log('#wpadminbar height:', height);
                    offset += height;
                }

                if ($headerBanner.length) {
                    const height = $headerBanner.outerHeight();
                    console.log('.header-banner height:', height);
                    offset += height;
                }

                if ($headerMiddle.length) {
                    const height = $headerMiddle.outerHeight();
                    console.log('.header-middle height:', height);
                    offset += height;
                }

                // const headerBottomHeight = $headerBottom.outerHeight();
                const headerBottomHeight = 64;
                console.log('.header-bottom--mobile height:', headerBottomHeight);
                offset += headerBottomHeight;

                const dropdownHeight = viewportHeight - offset;
                console.log('calculated .dropdown__row height:', dropdownHeight);

                $dropdownRow.css('height', dropdownHeight + 'px');
            } else {
                console.log('Required elements not found for dropdown height calculation.');
            }
        } else {
            console.log('Screen width > 768px, resetting .dropdown__row height');
            $('.dropdown__row').css('height', '');
        }
    }

    $(document).ready(updateDropdownHeight);
    $(window).on('resize orientationchange', updateDropdownHeight);
})(jQuery);
