<?php
    
    use Kirki\Compatibility\Kirki;
    
    if (Kirki::get_option('float_button_to_top_align') === "left") {
    $align_class_btn_to_top = 'left';
} else {
    $align_class_btn_to_top = 'right';
}

if (Kirki::get_option('float_button_to_top_enable')) {
    ?>
    <button class="back-to-top <?php echo $align_class_btn_to_top ?>" id="back-to-top">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            xml:space="preserve" width="50" height="50"
            style="enable-background:new 0 0 50 50">
            <path fill="#fff" d="M25 20.6 36.6 32l2.8-3L25 14.6 10.6 29l2.8 3z"/>
        </svg>
    </button>
    <?php
} ?>
