(function ($) {
    $(document).ready(function() {
        const cards = document.querySelectorAll('.prices .price-card');
        let currentIndex = 0;

        if (cards.length === 0) return;

        function activateNextCard() {
            cards.forEach(card => card.classList.remove('active'));

            cards[currentIndex].classList.add('active');

            currentIndex = (currentIndex + 1) % cards.length;
        }

        activateNextCard();
        setInterval(activateNextCard, 5000);
    });
})(jQuery);