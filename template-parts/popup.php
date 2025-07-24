<?php
    
    use Kirki\Compatibility\Kirki;
    
    if (Kirki::get_option('popup_enable')) {
    $popup_delay = Kirki::get_option('popup_delay') * 1000;
    wp_localize_script('girls-scripts', 'popup_delay', [$popup_delay]);
    ?>
        <div class="popup">
            <div class="popup-body">
                <button class="popup-close"></button>
                <div class="popup-content">
                    <img
                        class="icon"
                        src="<?php echo get_template_directory_uri() . '/assets/icons/subscribe.svg' ?>"
                        alt="image">
                    <div class="title"><?php echo Kirki::get_option('popup_text') ?></div>
                    <a
                        href="<?php echo Kirki::get_option('popup_button_link') ?>"
                        target="_blank"
                        class="dark-button">
                        <?php echo Kirki::get_option('popup_button_text') ?>
                    </a>
                </div>
            </div>
        </div>
    <?php
}
?>

