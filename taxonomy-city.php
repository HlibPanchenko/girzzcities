<?php

use ESC\Luna\Modules\CitiesModule;

get_header();

$current_city = CitiesModule::get_current_city_slug();

$tax_query = [];

if ($current_city) {
    $tax_query[] = [
            'taxonomy' => 'city',
            'field'    => 'slug',
            'terms'    => $current_city,
    ];
}

if (is_tax()) {
    $qo = get_queried_object();
    if (!empty($qo->taxonomy) && !empty($qo->term_id)) {
        if ($qo->taxonomy !== 'city') {
            $tax_query[] = [
                    'taxonomy' => $qo->taxonomy,
                    'field'    => 'term_id',
                    'terms'    => (int) $qo->term_id,
            ];
        }
    }
}

$args = [
        'post_type'      => 'models',
        'post_status'    => 'publish',
        'posts_per_page' => (int) get_option('posts_per_page'),
        'paged'          => max(1, (int) get_query_var('paged')),
];

if (!empty($tax_query)) {
    $args['tax_query'] = array_merge(['relation' => 'AND'], $tax_query);
}

$models_query = new WP_Query($args);

ob_start();

$post_count = $models_query->found_posts;

if ($models_query->have_posts()) {
    $bellowTwoClass = ($post_count <= 2) ? 'below-two' : '';
    ?>
    <div class="models-block archive">
        <div class="models-cards grid-style-2 <?php echo esc_attr($bellowTwoClass); ?>" id="anc-block">
            <?php
            while ($models_query->have_posts()) {
                $models_query->the_post();
                get_template_part('template-parts/templates-models-block/template_style_main');
            }
            ?>
        </div>

        <?php
        the_posts_pagination([
                'mid_size'  => 0,
                'end_size'  => 2,
                'prev_text' => '<',
                'next_text' => '>',
        ]);
        ?>
    </div>
    <?php
} else {
    ?>
    <p>Пока пусто.</p>
    <?php
}

$models_html = ob_get_clean();
wp_reset_postdata();

$term_description = is_tax() ? term_description() : '';

?>
    <main id="primary" class="site-main">
        <div class="container">

            <h1><?php echo esc_html(single_term_title('', false)); ?></h1>

            <?php
            if ($term_description && strpos($term_description, '</p>') !== false) {

                $term_description_with_models = preg_replace(
                        '/<\/p>/',
                        '</p>' . $models_html,
                        $term_description,
                        1
                );

                echo '<div class="taxonomy-description">';
                echo wp_kses_post($term_description_with_models);
                echo '</div>';

            } else {

                echo $models_html;

                if ($term_description) {
                    echo '<div class="taxonomy-description">';
                    echo wp_kses_post($term_description);
                    echo '</div>';
                }
            }
            ?>

        </div>
    </main>
<?php
get_footer();
