(function($) {
    function adjustWidth() {
        const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
        document.documentElement.style.setProperty('--scrollbar-width', `${scrollbarWidth}px`);
    }

    window.addEventListener('resize', adjustWidth);
    adjustWidth();

})(jQuery);
