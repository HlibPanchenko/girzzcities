<?php

use Kirki\Compatibility\Kirki;
use ESC\Luna\ThemeFunctions;

$header_style = Kirki::get_option('header_style');
if ($header_style == '1') {
    get_header();
} else {
    get_header('2');
}

$current_taxonomy = '';
$current_term = '';
$image_id = '';

if (is_tax()) {
    $queried_object = get_queried_object();
    $current_taxonomy = $queried_object->taxonomy;
    $current_term = $queried_object->name;
    $image_id = Kirki::get_option($current_taxonomy . '_archive_background_image');
}

$image_id = $image_id ?: null;

$taxonomy = $queried_object->taxonomy ?? '';
$term_id = $queried_object->term_id ?? '';
$term_name = single_term_title('', false);

$taxonomy_labels = get_taxonomy($taxonomy)->labels;
$taxonomy_title = $taxonomy_labels->singular_name ?? ucfirst($taxonomy);

$default_image = get_template_directory_uri() . '/assets/icons/hero-archive.jpg';
?>
    <main id="primary" class="site-main">
        <div class="container">
            <?php
            $city_content = get_term_meta(get_queried_object_id(), 'city_content', true);

            if ($city_content) {
                echo apply_filters('the_content', $city_content);
            }

            ?>
        </div>

    </main>
<?php
get_footer();
