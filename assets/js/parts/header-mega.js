(function ($) {
    $(document).ready(function () {
        initMenuLogic();      // 1. Логика подменю "services" (десктоп)
        initAlphabetFilter(); // 2. Алфавитный фильтр
        initMobileMenu();     // 3. Мобильное меню (клик вместо ховера)
        initDesktopHover();   // 4. Наведение/уход на десктопе
    });

    /**
     * 4. Наведение/уход (hover) на десктопе:
     *    Если пользователь находится внутри .menu-item-has-children
     *    ИЛИ внутри соответствующего .dropdown,
     *    то меню не скрывать, пока курсор не уйдёт за пределы обоих.
     */
    function initDesktopHover() {
        // Используем проверку ширины, чтобы на телефонах ховер не работал
        if ($(window).width() >= 992) {
            function openMenu(menuId) {
                $('.menu-item-has-children[data-menu-id="' + menuId + '"]').addClass('active');
                $('.dropdown[data-parent-id="' + menuId + '"]').addClass('active');
            }

            function closeMenu(menuId) {
                $('.menu-item-has-children[data-menu-id="' + menuId + '"]').removeClass('active');
                $('.dropdown[data-parent-id="' + menuId + '"]').removeClass('active');
            }

            // Наведение на li.menu-item-has-children
            $('.menu-item-has-children').on('mouseenter', function () {
                let menuId = $(this).data('menu-id');
                openMenu(menuId);
            });

            // Уход с li.menu-item-has-children
            $('.menu-item-has-children').on('mouseleave', function (e) {
                let menuId = $(this).data('menu-id');
                // Если курсор не ушёл в соответствующий .dropdown, закрываем
                if (!$(e.relatedTarget).closest('.dropdown[data-parent-id="' + menuId + '"]').length) {
                    closeMenu(menuId);
                }
            });

            // Наведение на .dropdown
            $('.dropdown').on('mouseenter', function () {
                let menuId = $(this).data('parent-id');
                openMenu(menuId);
            });

            // Уход с .dropdown
            $('.dropdown').on('mouseleave', function (e) {
                let menuId = $(this).data('parent-id');
                // Если курсор не перешёл обратно в .menu-item-has-children, закрываем
                if (!$(e.relatedTarget).closest('.menu-item-has-children[data-menu-id="' + menuId + '"]').length) {
                    closeMenu(menuId);
                }
            });
        }
    }

    /**
     * 3. Логика для мобильного меню (клик вместо ховера)
     */
    function initMobileMenu() {
        const burger = $('.burger');
        const headerBottom = $('.header-bottom--mobile');

        // Клик по бургеру
        burger.on('click', function () {
            if ($(window).width() < 992) {
                burger.toggleClass('active');
                headerBottom.toggleClass('opened');

                if (headerBottom.hasClass('opened')) {
                    // Отключаем прокрутку, если очень узкий экран
                    if ($(window).width() < 450) {
                        $('body').css('overflow', 'hidden');
                    }
                    // Активируем первый пункт
                    const firstMenuItem = headerBottom.find('.menu-item-has-children').first();
                    firstMenuItem.addClass('active');

                    // Показываем соответствующий .dropdown
                    let firstMenuId = firstMenuItem.data('menu-id');
                    $('.header-bottom--mobile .dropdowns .dropdown[data-parent-id="' + firstMenuId + '"]')
                        .css('display', 'block');

                    // Аналогично для первого пункта sub-menu
                    const firstMenuItemList = headerBottom.find('.sub-menu .menu-item').first();
                    firstMenuItemList.addClass('active');
                    let firstSubmenuId = firstMenuItemList.find('a').data('submenu-id');

                    // Показываем соответствующий .related__wrapper
                    $('.header-bottom--mobile .dropdown__row--services .related__wrapper').hide();
                    $('.header-bottom--mobile .dropdown__row--services .related__wrapper[data-submenu-id="' + firstSubmenuId + '"]').show();
                } else {
                    // Если закрываем меню, возвращаем скролл
                    $('body').css('overflow', '');
                    headerBottom.find('.menu-item-has-children').removeClass('active');
                    $('.header-bottom--mobile .dropdowns .dropdown').css('display', '');
                }
            }
        });

        // Клик вне области меню закрывает мобильное меню
        $(document).on('click', function (e) {
            if (
                $(window).width() < 992 &&
                !burger.is(e.target) &&
                !burger.has(e.target).length &&
                !headerBottom.is(e.target) &&
                !headerBottom.has(e.target).length &&
                !$(e.target).closest('.header-bottom--mobile .sub-menu').length &&
                !$(e.target).closest('.header-bottom--mobile .sub-menu a').length
            ) {
                headerBottom.removeClass('opened');
                burger.removeClass('active');
                headerBottom.find('.menu-item-has-children').removeClass('active');
                $('.header-bottom--mobile .dropdowns .dropdown').css('display', '');
            }
        });

        // Клик по основному пункту меню (li.menu-item-has-children > a)
        headerBottom.find('.menu-item-has-children > a').on('click', function (e) {
            if ($(window).width() < 992) {
                e.preventDefault();
                e.stopPropagation();

                const $this = $(this).parent();
                const menuId = $this.data('menu-id');
                const $dropdown = $('.header-bottom--mobile .dropdowns .dropdown[data-parent-id="' + menuId + '"]');

                // Закрываем все остальные
                headerBottom.find('.menu-item-has-children').not($this).removeClass('active');
                $('.header-bottom--mobile .dropdowns .dropdown').not($dropdown).css('display', '');

                // Открываем/закрываем выбранный
                $this.addClass('active');
                $dropdown.css('display', $this.hasClass('active') ? 'block' : '');
            }
        });

        // Клик по элементам sub-menu (переключение .related__wrapper)
        $('.header-bottom--mobile .sub-menu .menu-item, .header-bottom--mobile .sub-menu .menu-item a').on('click', function (e) {
            let href = $(this).attr('href');
            // Если это реальная ссылка (не "#"), уходим
            if (href && href !== '#') {
                return;
            }
            // Иначе переключаем блок
            e.preventDefault();
            let $menuItem = $(this).closest('.menu-item');
            let submenuId = $menuItem.find('a').data('submenu-id');

            // Активный .menu-item
            $('.sub-menu .menu-item').removeClass('active');
            $menuItem.addClass('active');

            // Прячем все related__wrapper, показываем нужный
            $('.header-bottom--mobile .dropdown__row--services .related__wrapper').hide();
            $('.header-bottom--mobile .dropdown__row--services .related__wrapper[data-submenu-id="' + submenuId + '"]').show();
        });
    }

    /**
     * 1. Логика подменю "services" (десктоп)
     */
    function initMenuLogic() {
        // Активируем первый пункт .sub-menu
        let firstMenuItem = $('.header-bottom--desktop .sub-menu .menu-item').first();
        let firstSubmenuId = firstMenuItem.find('a').data('submenu-id');
        firstMenuItem.addClass('active');

        // Скрываем все .related__grid, показываем только первый
        $('.header-bottom--desktop .dropdown__row--services .related__grid').hide();
        $('.header-bottom--desktop .dropdown__row--services .related__grid[data-submenu-id="' + firstSubmenuId + '"]').show();

        // При hover на .sub-menu .menu-item (только на десктопе)
        $('.header-bottom--desktop .sub-menu .menu-item').hover(
            function () {
                let submenuId = $(this).find('a').data('submenu-id');

                $('.header-bottom--desktop .sub-menu .menu-item').removeClass('active');
                $(this).addClass('active');

                // Скрываем все .related__grid, показываем нужный
                $('.header-bottom--desktop .dropdown__row--services .related__grid').hide();
                $('.header-bottom--desktop .dropdown__row--services .related__grid[data-submenu-id="' + submenuId + '"]').show();
            },
            function () {
                // Можно оставить пустым
            }
        );
    }

    /**
     * 2. Фильтр по алфавиту в разделе .dropdown__row--other
     */
    function initAlphabetFilter() {
        $(".dropdown .dropdown__row--other").each(function () {
            let $dropdown = $(this);
            let buttons = $dropdown.find(".alphabet-button");
            let items = $dropdown.find(".related__item");

            // Получаем список уникальных букв из data-letter
            let availableLetters = [];
            items.each(function () {
                let letter = $(this).data("letter");
                if (letter && !availableLetters.includes(letter)) {
                    availableLetters.push(letter);
                }
            });

            let defaultLetter = availableLetters.length > 0 ? availableLetters[0] : "all";

            let defaultButton = buttons.filter('[data-letter="' + defaultLetter + '"]');
            if (defaultButton.length) {
                buttons.removeClass("active");
                defaultButton.addClass("active");
            }

            // Показать только подходящие
            items.each(function () {
                let itemLetter = $(this).data("letter");
                $(this).toggle(defaultLetter === "all" || itemLetter === defaultLetter);
            });

            // Клик по кнопкам фильтра
            buttons.on("click", function () {
                let selectedLetter = $(this).data("letter");

                buttons.removeClass("active");
                $(this).addClass("active");
                console.log('a');

                items.each(function () {
                    let itemLetter = $(this).data("letter");
                    $(this).toggle(selectedLetter === "all" || itemLetter === selectedLetter);
                });
            });
        });
    }

})(jQuery);
