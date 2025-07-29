<?php

use Kirki\Compatibility\Kirki;
use ESC\Luna\Modules\CitiesModule;

$posts_per_page = get_option('posts_per_page') ?: 12;

$title = get_field('title');
$city_slug = CitiesModule::get_current_city_slug() ?? get_field('city');
$city_term = get_term_by('slug', $city_slug, 'city');

?>
<section class="wrapper">
    <div class="models-block" id="models-block-filter">
        <?php if ($title) { ?>
            <h2 class="title"><?php echo esc_html($title); ?></h2>
        <?php } ?>

        <?php include locate_template('template-parts/blocks/models-filter-block/parts/filter-part.php'); ?>

        <div class="loader-body">
            <span class="loader"></span>
        </div>

        <div class="models-cards" id="response">
            <?php
            $args = [
                'post_type'      => 'models',
                'posts_per_page' => $posts_per_page,
                'paged'          => 1
            ];

            if (!empty($city_term) && !is_wp_error($city_term)) {
                $args['tax_query'] = [
                    [
                        'taxonomy' => 'city',
                        'field'    => 'term_id',
                        'terms'    => [$city_term->term_id],
                    ],
                ];
            }

            $paged = isset($_POST['paged']) ? (int) $_POST['paged'] : 1;
            $query = new WP_Query($args);

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    get_template_part('template-parts/templates-models-block/template_' . $selectedStyle);
                }
                wp_reset_postdata();
            } else {
                echo esc_html__('Посты не найдены', 'pt-luna');
            }
            ?>
        </div>

        <div class="wrapper-more">
            <div class="button" id="more_btn" data-page="<?php echo esc_attr($paged + 1); ?>">
                <?php echo esc_html__('Показать еще', 'pt-luna'); ?>
            </div>
        </div>
    </div>
</section>
