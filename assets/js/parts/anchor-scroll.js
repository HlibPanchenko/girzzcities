(function($){
    $('a[href^="#"]').click(function(e){
        e.preventDefault();
        let href = $(this).attr('href');
        $('html, body').animate({ scrollTop: $(href).offset().top - 80}, 1000);
    });
})(jQuery);