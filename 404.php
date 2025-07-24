<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Devochki
 */

use Kirki\Compatibility\Kirki;

get_header();

$text = icl_t( 'Kirki', 'Text 404', Kirki::get_option('page_404_text') );
$image_id = Kirki::get_option('page_404_image');
$attr = ['class' => 'page-404-icon no-lazy'];
?>

<main id="primary" class="site-main">
    <section class="wrapper container">
        <div class="page-404-block">
            <?php
            if ($image_id) {
                echo wp_get_attachment_image($image_id, 'full', '', $attr);
            } else {
                ?>
                <span class="page_404_code">404</span>
                <?php
            }

            if(!empty($text)) {
                ?>
                <h1 class="page-404-title h3">
                    <?php echo esc_html__($text, 'pt-luna')?>
                </h1>
                <?php
            }
            ?>
            <a href="/" class="button">
                <?php echo esc_html__('Вернуться на Главную', 'pt-luna')?>
            </a>
        </div>
    </section>
</main>

<?php
get_footer();
