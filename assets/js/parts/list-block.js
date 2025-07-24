(function ($) {
    $(document).ready(function () {
        const listItems = document.querySelectorAll('.list-block ul li');
        const firstItem = listItems[0]; // Первый элемент, к которому привязан псевдоэлемент
        const pseudoElement = firstItem; // Псевдоэлемент двигается вместе с первым li
        const offsetTrigger = 150; // Смещение на 100 пикселей

        // Проверка видимости элемента (начинаем на 100 пикселей раньше)
        const isVisible = (el) => {
            const rect = el.getBoundingClientRect();
            return rect.top - offsetTrigger >= 0 && rect.top - offsetTrigger <= window.innerHeight / 2;
        };

        // Управляем положением псевдоэлемента
        const handleScroll = () => {
            let activeIndex = -1;

            listItems.forEach((li, index) => {
                if (activeIndex === -1 && isVisible(li)) {
                    activeIndex = index; // Запоминаем индекс активного элемента
                }
            });

            if (activeIndex !== -1) {
                // Вычисляем смещение от верхней границы первого элемента до активного
                const offset = listItems[activeIndex].offsetTop - listItems[0].offsetTop;
                pseudoElement.style.setProperty('--before-transform', `${offset}px`);
            }
        };

        // Инициализация
        $(window).on('scroll', handleScroll);
        handleScroll(); // Проверка при загрузке
    });
})(jQuery);
