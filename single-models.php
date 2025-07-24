<?php

use ESC\Luna\ThemeFunctions;
use Kirki\Compatibility\Kirki;

$header_style = Kirki::get_option('header_style');

if ($header_style == '1') {
    get_header();
} else {
    get_header('2');
}

$post_id = get_the_ID();

$options = get_the_terms($post_id, 'options');
?>

<main id="primary" class="site-main single-models">
    <div class="container">
        <div class="inner">
            <?php get_template_part('template-parts/templates-single-model/single-model-gallery'); ?>
            <?php get_template_part('template-parts/templates-single-model/single-model-info'); ?>
        </div>

        <?php get_template_part('template-parts/templates-single-model/single-model-tabs'); ?>

        <?php get_template_part('template-parts/related-posts'); ?>

    </div>
</main>

<?php get_footer(); ?>
