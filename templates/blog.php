<?php
/**
 * Template Name: Blog Page
 */
use Kirki\Compatibility\Kirki;


get_header();

$title_disabled = get_field('title_disabled');

?>

<main class="blog-page">
    <?php
    if (!$title_disabled) { ?>
        <section class="wrapper">
            <div class="container">
                <?php
                if ($title_disabled === false || empty($title_disabled)) { ?>
                    <h1 class="title"><?php the_title(); ?></h1>
                <?php } ?>
            </div>
        </section>
    <?php } ?>

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

    <div class="container">
        <?php
        the_content();
        ?>
    </div>

</main>

<?php
get_footer();
?>
