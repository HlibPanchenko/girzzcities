<?php
$current_post_id = get_the_ID();

$current_hair_color = get_field('model_hair_color', $current_post_id);
$current_lang = apply_filters( 'wpml_current_language', null ) ?? 'ru';

$translations['similar_models'] = [
    'ru' => 'Похожие модели',
    'en' => 'Similar models',
    'de' => 'Ähnliche Modelle',
    'uk' => 'Схожі моделі'
];

if (!empty($current_hair_color)) {
    $related_models = new WP_Query([
        'post_type' => 'models',
        'post__not_in' => [$current_post_id],
        'posts_per_page' => 4,
        'meta_query' => [
            [
                'key' => 'model_hair_color',
                'value' => $current_hair_color,
                'compare' => '=',
            ],
        ],
    ]);

    if ($related_models->have_posts()) {
        echo '<div class="related-posts info-card">';
        echo '<h2 class="h3">' . esc_html($translations['similar_models'][$current_lang]) . '</h2>';
        echo '<div class="related-posts-grid">';

        while ($related_models->have_posts()) {
            $related_models->the_post();
            get_template_part('template-parts/templates-models-block/template_style_main', null, ['post' => $post]);
        }

        echo '</div>';
        echo '</div>';
    }
    wp_reset_postdata();
}
?>
