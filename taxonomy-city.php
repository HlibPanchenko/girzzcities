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
            <div class="big-image-hero-block">
                <div class="big-image-hero-block__content pt-content">
                    <?php
                    $term_id = get_queried_object()->taxonomy.'_'.get_queried_object()->term_id;
                    if (post_type_archive_title('', false)) {
                        echo '<h1 class="title">' . post_type_archive_title('', false) . '</h1>';
                    } elseif (get_field('term_title', $term_id)) {
                        echo '<h1 class="title">' .  get_field('term_title', $term_id) . '</h1>';
                    } else {
                        the_archive_title('<h1 class="title">', '</h1>');
                    }

                    ?>

                </div>
            </div>

            <section class="wrapper">
                <?php
                if (have_rows('tag_content_before', $term_id)) {
                    while (have_rows('tag_content_before', $term_id)) {
                        the_row();

                        if (get_row_layout() == 'text_block') {
                            get_template_part('/template-parts/text-block');
                        }
                    }
                }

                $post_count = get_queried_object() -> count;

                if ($post_count < 10) {
                    ?>
                    <div class="notification">
                        <div class="text">
                            <?php
                            $term_title = single_term_title('', false);
                            $neighbor_type = '';
                            $postfix = '';
                            $post_label = '';

                            if (is_numeric($post_count)) {
                                $last_digit = $post_count % 10;

                                if ($last_digit === 1 && $post_count !== 11) {
                                    $post_label = esc_html__('анкета', 'pt-luna');
                                } elseif ($last_digit >= 2 && $last_digit <= 4 && ($post_count < 10 || $post_count > 20)) {
                                    $post_label = esc_html__('анкеты', 'pt-luna');
                                } else {
                                    $post_label = esc_html__('анкет', 'pt-luna');
                                }

                                $current_taxonomy = get_queried_object();
                                $taxonomy_label = get_taxonomy($current_taxonomy->taxonomy)->label;

                                $neighbor_type = ($taxonomy_label === 'Районы') ? esc_html__('районов', 'pt-luna') : esc_html__('станций', 'pt-luna');
                            }

                            echo sprintf(
                                esc_html__('По критерию: %1$s всего %2$d %3$s, вам также отображаются анкеты с соседних %4$s.', 'pt-luna'),
                                $term_title,
                                $post_count,
                                $post_label,
                                $neighbor_type
                            );
                            ?>
                        </div>
                    </div>

                    <?php
                }

                global $wp_query;
                $wp_query->set('post_type', 'models');
                $wp_query->get_posts();

                if (have_posts()) {
                    $selectedStyle = 'style_main';
                    $classStyle = 'grid-style-2';
                    $bellowTwoClass = '';
                    if ($post_count <= 2) {
                        $bellowTwoClass = 'below-two';
                    }
                    ?>
                    <div class="models-block archive">
                        <div class="models-cards <?php echo $classStyle . ' ' . $bellowTwoClass; ?>" id="anc-block">
                            <?php
                            while (have_posts()) {
                                the_post();
                                get_template_part('template-parts/templates-models-block/template_' . $selectedStyle);
                            }
                            ?>
                        </div>

                        <?php
                        the_posts_pagination([
                            'mid_size'  => 0,
                            'end_size' => 2,
                            'prev_text' => '<',
                            'next_text' => '>',
                        ]);
                        ?>
                    </div>
                    <?php
                }
                if ($post_count <= 10) {
                    get_template_part('template-parts/blocks/models-filter-block/models-filter-block');
                }

                if (have_rows('tag_content_after', $term_id)) {
                    while (have_rows('tag_content_after', $term_id)) {
                        the_row();

                        if (get_row_layout() == 'text_block') {
                            get_template_part('/template-parts/text-block');
                        }
                    }
                }
                ?>
            </section>

            <div class="big-image-hero-block">
                <div class="big-image-hero-block__content pt-content">
                    <?php

                    echo term_description();

                    ?>

                </div>
            </div>
        </div>

    </main>
<?php
get_footer();
