<?php
$uniq_id = uniqid('pt-models-block-');
$taxonomy = get_field('models_taxonomy');
$term = get_term($taxonomy);
$taxonomy_name = $term ? $term->taxonomy : '';
$models_count = get_field('models_count');
$selectedStyle = get_field('models_style_block') ?: 'style_1';
$class = $selectedStyle === 'style_1' ? 'style_1' : 'style_2';

$title_color = get_field('title_color');
$button_bg_color = get_field('button_bg_color');
$button_color = get_field('button_color');
$button_hover = get_field('button_hover');

?>
<section class="wrapper models-block">
    <div id="<?php echo $uniq_id; ?>" class="models-block-container">
        <h2 class="title"><?php echo get_field('title') ?></h2>
        <div class="cards-wrapper <?php echo $class; ?>" id="anc-block">
            <?php
            if (isset($taxonomy)) {
                $loop = new WP_Query([
                    'post_type' => 'models',
                    'tax_query' => [
                        [
                            'taxonomy' => $taxonomy_name,
                            'field' => 'term_id',
                            'terms' => $taxonomy,
                        ]
                    ],
                    'posts_per_page' => $models_count
                ]);
            } else {
                $loop = new WP_Query([
                    'post_type' => 'models',
                    'tax_query' => [],
                    'posts_per_page' => $models_count
                ]);
            }


            while ($loop->have_posts()) {
                $loop->the_post();
                get_template_part('template-parts/templates-models-block/template_' . $selectedStyle);
            }

            wp_reset_postdata();
            ?>
        </div>
        <?php
        if (isset(get_field('button')['url'])) {
            ?>
            <a href="<?php echo get_field('button')['url'] ?>" class="button">
                <?php echo get_field('button')['title'] ?>
            </a>
            <?php
        } ?>
    </div>
</section>

<style>
    <?php
    echo <<<EOT
         #$uniq_id .title {
            color: $title_color;
         }
         #$uniq_id .button {
            color: $button_color;
            background-color: $button_bg_color;
         }
         
         @media (hover: hover) {
             #$uniq_id .button:hover {
                 background-color: $button_hover;
             }
         }
    EOT;
    ?>
</style>
