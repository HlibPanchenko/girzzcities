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
                            <?php if (is_active_sidebar('footer-menu-3')) {
                                dynamic_sidebar('footer-menu-3');
                            } ?>
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
