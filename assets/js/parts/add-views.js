(function ($) {
    $(document).ready(function () {
        add_view();
    });

    function add_view()
    {
        let filter = $("#add-view");

        $.ajax({
            url: filter.attr("action"),
            type: filter.attr("method"),
            data : $('form').serialize()
        });
        return false;
    }
})(jQuery);