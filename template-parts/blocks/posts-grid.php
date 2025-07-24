<?php
$section_title = get_field('title');
$post_quantity = get_field('quantity') ?: 10;

$args = [
    'posts_per_page' => 1,
    'post_status'    => 'publish',
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
?>

<section class="blog-blocks">
    <h2><?php esc_html_e('Related articles', 'pt-luna'); ?></h2>

    <?php if (have_posts()) : ?>
        <?php if ($section_title) { ?>
            <h2 class="h3"><?php echo esc_html($section_title); ?></h2>
        <?php } ?>
        <div class='list-posts'>
            <?php
            $args = [
                'posts_per_page' => $post_quantity,
                'post__not_in'   => [$latest_post_id],
            ];
            $main_query = new WP_Query($args);

            while ($main_query->have_posts()) {
                $main_query->the_post();
                get_template_part('template-parts/templates-blog-post/blog-post');
            }
            wp_reset_postdata();
            ?>
        </div>
    <?php endif; ?>

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
