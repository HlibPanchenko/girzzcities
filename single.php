<?php

get_header();

use Kirki\Compatibility\Kirki;
use \ESC\Luna\ThemeFunctions;

$post_id = get_the_ID();

$title = icl_t( 'Kirki', 'Toc Text', Kirki::get_option('toc_text') );
?>
<main id="primary" class="homepage single-blog">
    <section class="single-hero">
        <div class="wrapper">
            <div class="box container">
                <div class="col">
                    <?php
                    if (has_post_thumbnail()) {
                        ?>
                        <div class="post-thumbnail">
                            <?php echo get_the_post_thumbnail(); ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>

                <div class="col">
                    <h1 id="blog_<?php echo $post_id; ?>_1"><?php the_title(); ?></h1>
                </div>

            </div>

        </div>
    </section>

    <section class="wrapper container">
        <div class="content">
            <div class="aside">
                <div class="toc">
                    <div class="toc-wrapper">
                        <h2 class="title h4">
                            <?php echo $title; ?>
                        </h2>

                        <ul>
                            <?php
                            if (have_posts()) {
                                while (have_posts()) {
                                    the_post();
                                    $content = apply_filters('the_content', get_the_content());
                                    preg_match_all('/<h[2-3][^>]*>(.*?)<\/h[2-3]>/', $content, $matches);
                                    $counter = 1;
                                    ?>
                                    <li>
                                        <a href="#blog_<?php echo $post_id; ?>_<?php echo $counter; ?>" class="toc-link"><?php the_title(); ?></a>
                                    </li>
                                    <?php
                                    foreach ($matches[1] as $match) {
                                        $id = 'blog_' . $post_id . '_' . ++$counter;
                                        ?>
                                        <li>
                                            <a href="#<?php echo $id; ?>" class="toc-link"><?php echo $match; ?></a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>

                </div>
            </div>
            <div class="pt-content">

                <?php
                if (have_posts()) {
                    while (have_posts()) {
                        the_post();
                        $content = apply_filters('the_content', get_the_content());

                        $content = preg_replace_callback('/<h([2-3])[^>]*>(.*?)<\/h\1>/i', function ($matches) {
                            static $counter = 2;
                            $post_id = get_the_ID();
                            $heading_number = $counter++;
                            $id = 'blog_' . $post_id . '_' . $heading_number;
                            return '<h' . $matches[1] . ' id="' . $id . '">' . $matches[2] . '</h' . $matches[1] . '>';
                        }, $content);

                        echo $content;
                    };
                };
                ?>
            </div>
</div>
    </section>


    <section class="wrapper container wrapper-related">
        <div class="related_blog">
           <h2 class="req-title"><?php echo esc_html__('More from our blog', 'pt-luna')?></h2>
            <?php
            $related_category = get_categories() ? get_categories()[array_rand(get_categories())] : 1;

            $args = [
                'category' => $related_category,
                'post_type' => 'post',
                'posts_per_page' => 4,
                'orderby' => 'rand',
                'post__not_in' => [$post_id]
            ];

            $query = new WP_Query($args);

            if ($query->have_posts()) {
                ?>
                <div class="list-posts">
                    <?php while ($query->have_posts()) {
                        $query->the_post();
                        get_template_part('template-parts/templates-blog-post/blog-post');
                    } ?>
                </div>
                <?php
            }
            wp_reset_postdata();
            ?>
        </div>
    </section>

    <?php get_template_part('template-parts/blocks/global/cta-block'); ?>

</main>

<?php
// Добавляем схему JSON-LD для улучшения индексации
$schema_data = [
    "@context" => "https://schema.org",
    "@type" => "Article",
    "headline" => get_the_title(),
    "description" => get_the_excerpt(),
    "mainEntityOfPage" => get_permalink(),
    "image" => get_the_post_thumbnail_url(),
    "author" => [
        "@type" => "Person",
        "name" => get_the_author()
    ],
    "publisher" => [
        "@type" => "Organization",
        "name" => get_bloginfo('name'),
        "logo" => [
            "@type" => "ImageObject",
            "url" => get_site_icon_url()
        ]
    ],
    "datePublished" => get_the_date('c'),
    "dateModified" => get_the_modified_date('c'),
    "articleBody" => strip_tags(get_the_content())
];

echo '<script type="application/ld+json">' . json_encode($schema_data) . '</script>';
?>

<?php
get_footer();
