(function($) {
    $(document).ready(function() {
        var $dropdown = $(".options");

        if ($dropdown.length === 0) return;

        var $selected = $dropdown.find(".options__selected");
        var $selected_text = $dropdown.find(".options__selected span");
        var $list = $dropdown.find(".options__list");
        var $items = $dropdown.find(".options__item");

        var $priceBlock = $(".price");
        var $label = $priceBlock.find(".label");
        var $num = $priceBlock.find(".num");

        var currency = typeof my_ajax_object !== 'undefined' ? my_ajax_object.site_currency : '₽';

        $selected.on("click", function() {
            $dropdown.toggleClass("open");
            $list.toggleClass("open");
        });

        $items.on("click", function() {
            var newText = $(this).text();
            var newPrice = $(this).data("price");

            $selected_text.text(newText);
            $label.text(newText);
            $num.text(newPrice + currency);

            $dropdown.removeClass("open");
            $list.removeClass("open");
        });

        $(document).on("click", function(e) {
            if (!$dropdown.is(e.target) && $dropdown.has(e.target).length === 0) {
                $dropdown.removeClass("open");
                $list.removeClass("open");
            }
        });
    });
})(jQuery);
