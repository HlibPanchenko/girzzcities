(function ($) {
    $(".acf-radio-list li").on("click", function (event) {
        $(".acf-radio-list li").removeClass("active");
        $(this).prevAll("li").addBack().addClass("active");

        var clickedIndex = $(this).index();

        var elementsArray = [];
        $(".acf-radio-list li").each(function () {
            elementsArray.push(this);
        });
    });

    $("#commentform").submit(function(event) {
        var authorInput = $("#author");
        if (authorInput.val().trim() === "") {
            event.preventDefault();
            authorInput.focus();
        }
    });
})(jQuery);