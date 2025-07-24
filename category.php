<?php
/**
 * The template for displaying category post pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PT Luna
 */

use Kirki\Compatibility\Kirki;

$header_style = Kirki::get_option('header_style');
if ($header_style == '1') {
    get_header();
} else {
    get_header('2');
}
?>
<main class="blog-page">
    <section class="blog-header">
        <?php
        //        $term_id = get_queried_object()->taxonomy.'_'.get_queried_object()->term_id;
        //        if (post_type_archive_title('', false)) {
        //            echo '<h1 class="title">' . post_type_archive_title('', false) . '</h1>';
        //        } elseif (get_field('term_title', $term_id)) {
        //            echo '<h1 class="title">' .  get_field('term_title', $term_id) . '</h1>';
        //        } else {
        //            the_archive_title('<h1 class="title">', '</h1>');
        //        }
        //        ?>
    </section>

    <section class="blog-hero">
        <?php
        $args = [
            'posts_per_page' => 1,
            'post_status' => 'publish',
        ];
        $latest_post_query = new WP_Query($args);

        $latest_post_id = null;
        if ($latest_post_query->have_posts()) {
            while ($latest_post_query->have_posts()) {
                $latest_post_query->the_post();
                $latest_post_id = get_the_ID();
            }
            wp_reset_postdata();
        }

        if ($latest_post_id) {
            ?>
            <div class="latest-post">
                <div class="container">
                    <?php
                    $args = [
                        'post__in' => [$latest_post_id],
                        'posts_per_page' => 1,
                    ];
                    $latest_post_query = new WP_Query($args);

                    while ($latest_post_query->have_posts()) {
                        $latest_post_query->the_post();
                        get_template_part('template-parts/templates-blog-post/latest-blog-post');
                    }

                    wp_reset_postdata();
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
    </section>
    <section class="blog-blocks container">

        <?php

        if (have_posts()) {
            ?>
           <h2 class="h3"><?php echo esc_html__('More blog posts', 'pt-luna'); ?></h2>
            <div class='list-posts'>
                <?php
                $args = [
                    'posts_per_page' => 10,
                    'post__not_in' => [$latest_post_id],
                ];
                $main_query = new WP_Query($args);

                while ($main_query->have_posts()) {
                    $main_query->the_post();
                    get_template_part('template-parts/templates-blog-post/blog-post');
                }
                wp_reset_postdata();
                ?>
            </div>
            <?php
        }
        ?>

        <div class="pagination">
            <?php the_posts_pagination([
                'prev_text' => '<',
                'next_text' => '>',
            ]); ?>
        </div>

        <div class="blog-footer">
            <?php echo term_description(); ?>
        </div>
    </section>

</main>

<?php
get_sidebar();
get_footer();
