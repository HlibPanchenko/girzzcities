<?php
use ESC\Luna\ThemeFunctions;
use Kirki\Compatibility\Kirki;

if (!function_exists('renderSearch')) {
    function renderSearch($placeholder = 'Поиск...'): string
    {
        return '
    <div class="search">
        <label>
            <input type="text" placeholder="' . esc_html($placeholder) . '">
             <span>
            ' . ThemeFunctions::getInlineSvg('search') . '
            </span>
        </label>
    </div>';
    }
}

if (!function_exists('generateTaxonomyFilter')) {
    function generateTaxonomyFilter($taxonomy, $container_id, $select_all_label): void
{
    $terms = get_terms([
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
        'parent' => 0,
        'lang' => apply_filters('wpml_current_language', null),
    ]);

//    var_dump($terms);
    if (! empty($terms)) {
        ?>
        <div class="list grid" id="<?php echo esc_attr($container_id); ?>">
            <div class="checkbox parent">
                <label>
                    <input
                        type="checkbox"
                        name="<?php echo esc_attr($taxonomy); ?>[]"
                        value="all"
                        id="select_all_<?php echo esc_attr($taxonomy); ?>"
                        class="select-all-checkbox check"
                        data-container="<?php echo esc_attr($container_id); ?>">
                    <?php echo esc_html($select_all_label); ?>
                </label>
            </div>
            <?php
            foreach ($terms as $term) {
                ?>
                <div class="checkbox parent">
                    <label>
                        <input
                            class="check"
                            type="checkbox"
                            name="<?php echo esc_attr($taxonomy); ?>[]"
                            value="<?php echo esc_attr($term->slug); ?>"
                            id="<?php echo esc_attr($term->slug); ?>">
                        <?php echo esc_html($term->name); ?> <span>(<?php echo esc_html($term->count); ?>)</span>
                    </label>
                </div>
                <?php
                $child_terms = get_term_children($term->term_id, $taxonomy);
                if (! empty($child_terms)) {
                    foreach ($child_terms as $child_term_id) {
                        $child_term = get_term_by('id', $child_term_id, $taxonomy);
                        if ($child_term) {
                            ?>
                            <div class="checkbox">
                                <label>
                                    <input
                                            class="check"
                                            type="checkbox"
                                            name="<?php echo esc_attr($taxonomy); ?>[]"
                                            value="<?php echo esc_attr($child_term->slug); ?>"
                                            id="<?php echo esc_attr($child_term->slug); ?>">
                                    <?php echo esc_html($child_term->name); ?> <span>(<?php echo esc_html($child_term->count); ?>)</span>
                                </label>
                            </div>
                            <?php
                        }
                    }
                }
            }
            ?>
        </div>
        <?php
    }
}
}

if (!function_exists('renderPriceRange')) {
    function renderPriceRange($name, $label, $min, $max, $step): string
    {
        $currency_symbol = get_field('site_currency', 'option') ?: '₽';

        return '
    <div class="wrap" id="' . esc_attr($name) . '">
        <div class="parent">' . esc_html($label) . '</div>
        <div class="price-input">
            <div class="field">
                <label>
                    <span>' . esc_html($currency_symbol) . '</span>
                    <input type="number" class="input-min" value="' . esc_attr($min) . '">
                </label>
            </div>
            <div class="field">
                <label>
                    <span>' . esc_html($currency_symbol) . '</span>
                    <input type="number" class="input-max" value="' . esc_attr($max) . '">
                </label>
            </div>
        </div>
    </div>';
    }
}

$city = get_field('city');

?>

<form class="filter" action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="filter">
    <div class="tabs">
        <div class="tabs-wrap">
            <div class="tabs-buttons">
                <?php
               $tab_data = [
					['tab' => 'tab1', 'text' => __('Услуги', 'pt-luna'), 'hide_field' => 'services_filter_hide'],
					['tab' => 'tab2', 'text' => __('Районы', 'pt-luna'), 'hide_field' => 'area_filter_hide'],
					['tab' => 'tab3', 'text' => __('Станции метро', 'pt-luna'), 'hide_field' => 'metro_filter_hide'],
					['tab' => 'tab4', 'text' => __('Цены', 'pt-luna'), 'hide_field' => 'price_filter_hide'],
					['tab' => 'tab5', 'text' => __('Параметры девушек', 'pt-luna'), 'hide_field' => 'params_filter_hide'],
				];


                ?>

                <?php
                foreach ($tab_data as $index => $data) {
                    $tab_index = $index + 1;

                    if (is_archive() && !empty($data['hide_field'])) {
                        $hide_field = Kirki::get_option('archive_' . $data['hide_field']);
                    } else {
                        $hide_field = get_field($data['hide_field']);
                    }

                    if ($hide_field) {
                        continue;
                    }

                    ?>
                    <button class="tab-button" type="button" data-tab="<?php echo esc_attr($data['tab']); ?>">
                        <span class="tab-text">
                            <?php echo esc_html($data['text']); ?>
                        </span>
                    </button>
                <?php } ?>
            </div>

        </div>
        <div class="tabs-content">
            <div class="tab-content" id="tab1">
                <?php echo renderSearch( __( 'Поиск по услугам...', 'pt-luna' ) ); ?>

                <?php
                generateTaxonomyFilter(
                    'services',
                    'services_checkbox_container',
                    esc_html__('Добавить все', 'pt-luna')
                );
                ?>
            </div>
            <div class="tab-content" id="tab2">
                <?php echo renderSearch( __( 'Поиск по районам...', 'pt-luna' ) ); ?>

                <?php
                generateTaxonomyFilter(
                    'area',
                    'area_checkbox_container',
                    esc_html__('Добавить все', 'pt-luna')
                );
                ?>
            </div>
            <div class="tab-content" id="tab3">
               <?php echo renderSearch( __( 'Поиск по метро...', 'pt-luna' ) ); ?>

                <?php
                generateTaxonomyFilter(
                    'metro',
                    'metro_checkbox_container',
                    esc_html__('Добавить все', 'pt-luna')
                );
                ?>
            </div>
            <div class="tab-content" id="tab4">
                <div class="range-content" id="price_range_container">
                    <?php
                   	echo renderPriceRange('price-hour', __('Цена за час', 'pt-luna'), 0, 25000, 1000);
					echo renderPriceRange('price-two-hour', __('Цена за 2 часа', 'pt-luna'), 0, 50000, 1000);
					echo renderPriceRange('price-night', __('Цена за ночь', 'pt-luna'), 0, 120000, 5000);


                    ?>
                </div>
            </div>
            <div class="tab-content" id="tab5">
                <div class="range-content" id="params_checkbox_container">
                    <div class="wrap" id="model-height">
                        <div class="parent"><?php echo esc_html__('Рост, cm', 'pt-luna'); ?></div>
                        <div class="price-input">
                            <div class="field">
                                <span><?php echo esc_html__('От', 'pt-luna'); ?></span>
                                <label>
                                    <input type="number" class="input-min" value="140">
                                </label>
                            </div>
                            <div class="field">
                                <span><?php echo esc_html__('До', 'pt-luna'); ?></span>
                                <label>
                                    <input type="number" class="input-max" value="200">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="wrap" id="model-weight">
                        <div class="parent"><?php echo esc_html__('Вес, kg', 'pt-luna'); ?></div>
                        <div class="price-input">
                            <div class="field">
                                <span><?php echo esc_html__('От', 'pt-luna'); ?></span>
                                <label>
                                    <input type="number" class="input-min" value="30">
                                </label>
                            </div>
                            <div class="field">
                                <span><?php echo esc_html__('До', 'pt-luna'); ?></span>
                                <label>
                                    <input type="number" class="input-max" value="100">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="wrap" id="model-age">
                        <div class="parent"><?php echo esc_html__('Возраст', 'pt-luna'); ?></div>
                        <div class="price-input">
                            <div class="field">
                                <span><?php echo esc_html__('От', 'pt-luna'); ?></span>
                                <label>
                                    <input type="number" class="input-min" value="18">
                                </label>
                            </div>
                            <div class="field">
                                <span><?php echo esc_html__('До', 'pt-luna'); ?></span>
                                <label>
                                    <input type="number" class="input-max" value="60">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="params">
                    <div class="list-v" id="bust_checkbox_container">
                        <div class="params-title">
                            <?php echo esc_html__('Грудь', 'pt-luna'); ?>
                        </div>
                        <div class="checkbox parent">
                            <label>
                                <input
                                    type="checkbox"
                                    name="bust-size[]"
                                    value="all"
                                    id="select_all_bust"
                                    class="select-all-checkbox check"
                                    data-container="bust_checkbox_container">
                                <?php echo esc_html__('Добавить все', 'pt-luna'); ?>
                            </label>
                        </div>
                        <?php
                        $meta_key = 'model_bust_size';

                        $args = [
                            'post_type' => 'models',
                            'posts_per_page' => -1,
                        ];

                        $query = new WP_Query($args);

                        $unique_values = [];

                        if ($query->have_posts()) {
                            while ($query->have_posts()) {
                                $query->the_post();
                                $meta_values = get_post_meta(get_the_ID(), $meta_key, false);

                                foreach ($meta_values as $value) {
                                    if (! empty($value) && !in_array($value, $unique_values, true)) {
                                        $unique_values[] = $value;
                                    }
                                }
                            }
                            wp_reset_postdata();
                        }

                        $bust_sizes = array_unique($unique_values);
                        sort($bust_sizes);

                        foreach ($bust_sizes as $value => $label) { ?>
                            <div class="checkbox">
                                <label>
                                    <?php echo $label; ?>
                                    <input
                                        class="check"
                                        type="checkbox"
                                        name="bust-size[]"
                                        value="<?php echo $label; ?>"
                                        id="bust-<?php echo $label; ?>">
                                </label>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="list-v" id="hair_color_checkbox_container">
                        <div class="params-title">
                            <?php echo esc_html__('Цвет волос', 'pt-luna'); ?>
                        </div>
                        <div class="checkbox parent">
                            <label>
                                <input
                                        type="checkbox"
                                        name="hair-color[]"
                                        value="all"
                                        id="select_all_hair_color"
                                        class="select-all-checkbox check"
                                        data-container="hair_color_checkbox_container">
                                <?php echo esc_html__('Добавить все', 'pt-luna'); ?>
                            </label>
                        </div>
                        <?php
                        $meta_key = 'model_hair_color';

                        $hair_color_translations = [
                            'Блондинка' => [
                                'en' => 'Blonde',
                                'de' => 'Blondine',
                            ],
                            'Брюнетка' => [
                                'en' => 'Brunette',
                                'de' => 'Brünette',
                            ],
                            'Шатенка' => [
                                'en' => 'Brown-haired',
                                'de' => 'Braunhaarige',
                            ],
                            'Русая' => [
                                'en' => 'Light brown',
                                'de' => 'Hellbraun',
                            ],
                            'Рыжая' => [
                                'en' => 'Redhead',
                                'de' => 'Rothaarige',
                            ],
                        ];

                        $current_lang = defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : 'ru';

                        $args = [
                            'post_type' => 'models',
                            'posts_per_page' => -1,
                        ];

                        $query = new WP_Query($args);

                        $unique_values = array();

                        if ($query->have_posts()) {
                            while ($query->have_posts()) {
                                $query->the_post();
                                $meta_values = get_post_meta(get_the_ID(), $meta_key, false);

                                foreach ($meta_values as $value) {
                                    if (! in_array(
                                        $value,
                                        $unique_values,
                                        true
                                    )) {
                                        $unique_values[] = $value;
                                    }
                                }
                            }
                            wp_reset_postdata();
                        }

                        $hair_color = array_unique($unique_values);
                        sort($hair_color)

                        ?>

                        <?php foreach ($hair_color as $value => $label) {
                            $translated_label = $hair_color_translations[$label][$current_lang] ?? $label;
                            ?>
                            <div class="checkbox">
                                <label>
                                    <?php echo esc_html($translated_label); ?>
                                    <input
                                            class="check"
                                            type="checkbox"
                                            name="hair-color[]"
                                            value="<?php echo esc_attr($label); ?>">
                                </label>
                            </div>
                        <?php } ?>

                    </div>

                    <div class="checkboxes">
                        <?php
                        $checkboxValue = $_POST['checkbox'] ?? '';
                        $checkboxChecked = ($checkboxValue === 'checked') ? 'checked' : '';

                        $checkboxVideoValue = $_POST['model_has_video'] ?? '';
                        $modelHasVideoChecked = ($checkboxVideoValue === 'checked') ? 'checked' : '';
                        ?>
                        <label class="checkbox-wrap" for="model_verified_checkbox">
                            <?php echo esc_html__('Проверенная', 'pt-luna'); ?>
                            <div class="checkbox">
                                <input
                                        type="checkbox"
                                        id="model_verified_checkbox"
                                        name="checkbox"
                                        value="checked"
                                    <?php echo $checkboxChecked; ?> >
                            </div>
                        </label>

                        <label class="checkbox-wrap" for="model_has_video">
                            <?php echo esc_html__('С видео', 'pt-luna'); ?>
                            <div class="checkbox">
                                <input
                                        type="checkbox"
                                        id="model_has_video"
                                        name="model_has_video"
                                        value="checked"
                                    <?php echo $modelHasVideoChecked; ?> >
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="action" value="myfilter">
    <?php

    $selectedStyle = 'style_main';
    $posts_per_page = get_option('posts_per_page') ?: 12;
    ?>
    <input type="hidden" name="selected_style" value="<?php echo $selectedStyle; ?>">
    <input type="hidden" name="post_per_page" value="<?php echo $posts_per_page; ?>">
    <input type="hidden" name="acf_city_id" value="<?php echo esc_attr($city); ?>">
</form>