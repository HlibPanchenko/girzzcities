<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Devochki
 */

$current_city = isset($_COOKIE['selected_city']) ? sanitize_title($_COOKIE['selected_city']) : '';
$footer_location = 'footer_menu'; // default

if ($current_city) {
    $possible_footer = 'footer_menu_' . $current_city;
    if (has_nav_menu($possible_footer)) {
        $footer_location = $possible_footer;
    }
}
?>
    <footer id="colophon" class="site-footer">

        <div class="footer-content container">
            <div class="footer-top">
                <div class="menu-container">
                    <?php if (is_active_sidebar('footer-menu-1')) {
                        dynamic_sidebar('footer-menu-1');
                    } ?>
                </div>
                <div class="menu-container">
                    <div class="wrapper">
                        <div class="col">
                            <?php if (is_active_sidebar('footer-menu-2')) {
                                dynamic_sidebar('footer-menu-2');
                            } ?>
                        </div>
                        <div class="col">
                            <div class="menubox">
                                <p class="menubox-title">Меню</p>
                                <?php
                                wp_nav_menu([
                                    'theme_location' => $footer_location,
                                    'menu_class'     => 'footer-menu',
                                    'container'      => false,
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="footer-middle">
                <div class="wrapper">
                    <div class="col">
                        <?php if (is_active_sidebar('footer-menu-4')) {
                            dynamic_sidebar('footer-menu-4');
                        } ?>
                    </div>
                    <div class="col">
                        <?php if (is_active_sidebar('footer-menu-5')) {
                            dynamic_sidebar('footer-menu-5');
                        } ?>
                    </div>
                </div>

            </div>
            <div class="footer-bottom">
                <?php dynamic_sidebar('footer-1'); ?>
            </div>
        </div>
    </footer>
</div>

<?php wp_footer(); ?>

</body>
</html>
