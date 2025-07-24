<section class="wrapper last-post-block">
    <div class="req-title h3"><?php echo get_field('last_post_title') ?></div>
    <?php

    $amount_post = get_field('last_post_amount');

    $args = [
        'post_type' => 'post',
        'posts_per_page' => $amount_post,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ?>
        <div class="last-post-wrap">
            <?php while ($query->have_posts()) {
                $query->the_post();
                get_template_part('template-parts/templates-blog-post/blog-post');
            } ?>
        </div>
        <?php
    }
    wp_reset_postdata();
    ?>
</section>