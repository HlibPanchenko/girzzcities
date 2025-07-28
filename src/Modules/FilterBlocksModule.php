<?php

namespace ESC\Luna\Modules;

use JetBrains\PhpStorm\NoReturn;
use WP_Query;

class FilterBlocksModule
{
    public static function registerHooks(): void
    {
        add_action('wp_ajax_myfilter', [__CLASS__, 'registerFilterFunction']);
        add_action('wp_ajax_nopriv_myfilter', [__CLASS__, 'registerFilterFunction']);
        add_action('save_post', [__CLASS__, 'toggleCheckboxHasVideo']);
    }
    
    #[NoReturn] public static function registerFilterFunction(): void
    {
        $services = $_POST['services'] ?? '';
        $area = $_POST['area'] ?? '';
        $metro = $_POST['metro'] ?? '';
        $checkboxValue = $_POST['checkbox'] ?? '';
        $checkboxVideoValue = $_POST['model_has_video'] ?? '';
        $paged = isset($_POST['paged']) ? (int) $_POST['paged'] : 1;
        $bustSize = $_POST['bust-size'] ?? '';
        $hairColor = $_POST['hair-color'] ?? '';
        $priceHour = $_POST['price-hour'] ?? '';
        $priceTwoHour = $_POST['price-two-hour'] ?? '';
        $priceNight = $_POST['price-night'] ?? '';
        $modelHeight = $_POST['model-height'] ?? '';
        $modelWeight = $_POST['model-weight'] ?? '';
        $modelAge = $_POST['model-age'] ?? '';
        $posts_per_page = $_POST['posts_per_page'] ?? '';
        $selectedStyle = $_POST['selected_style'];
        $acf_city_id = !empty($_POST['acf_city_id']) ? intval($_POST['acf_city_id']) : 0;

        $args = [
            'post_type' => 'models',
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
            'suppress_filters' => false,
        ];

        $meta_query = [];

        $meta_query = [
            'relation' => 'AND'
        ];

        if (! empty($priceHour)) {
            $priceHour = array_map('intval', $priceHour);
            sort($priceHour);
            $minPriceHour = $priceHour[0];
            $maxPriceHour = $priceHour[1];

            $meta_key = 'model_price_1';
            $price_1 = $minPriceHour . $maxPriceHour;

            $meta_query[] = [
                'key' => $meta_key,
                'value' => [$minPriceHour, $maxPriceHour],
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            ];
        }

        if (! empty($priceTwoHour)) {
            $priceTwoHour = array_map('intval', $priceTwoHour);
            sort($priceTwoHour);
            $minPriceTwoHour = $priceTwoHour[0];
            $maxPriceTwoHour = $priceTwoHour[1];

            $meta_key = 'model_price_2';
            $price_2 = $minPriceTwoHour . $maxPriceTwoHour;

            $meta_query[] = [
                'key' => $meta_key,
                'value' => [$minPriceTwoHour, $maxPriceTwoHour],
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            ];
        }

        if (!empty($priceNight)) {
            $priceNight = array_map('intval', $priceNight);
            sort($priceNight);
            $minPriceNight = $priceNight[0];
            $maxPriceNight = $priceNight[1];

            $meta_key = 'model_price_night';
            $price_night = $minPriceNight . $maxPriceNight;

            $meta_query[] = [
                'key' => $meta_key,
                'value' => [$minPriceNight, $maxPriceNight],
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            ];
        }

        if (!empty($modelHeight)) {
            $modelHeight = array_map('intval', $modelHeight);
            sort($modelHeight);
            $minHeight = $modelHeight[0];
            $maxHeight = $modelHeight[1];

            $height = $minHeight . $maxHeight;

            $meta_query[] = [
                'key' => 'model_height',
                'value' => [$minHeight, $maxHeight],
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            ];
        }

        if (!empty($modelWeight)) {
            $modelWeight = array_map('intval', $modelWeight);
            sort($modelWeight);
            $minWeight = $modelWeight[0];
            $maxWeight = $modelWeight[1];

            $weight = $minWeight . $maxWeight;

            $meta_query[] = [
                'key' => 'model_weight',
                'value' => [$minWeight, $maxWeight],
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            ];
        }

        if (!empty($modelAge)) {
            $modelAge = array_map('intval', $modelAge);
            sort($modelAge);
            $minAge = $modelAge[0];
            $maxAge = $modelAge[1];

            $age = $minAge . $maxAge;

            $meta_query[] = [
                'key' => 'model_age',
                'value' => [$minAge, $maxAge],
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            ];
        }

        if (! empty($bustSize)) {
            $bust = implode('', $bustSize);
            $meta_query[] = [
                'key' => 'model_bust_size',
                'value' => $bustSize,
                'compare' => 'IN'
            ];
        }

        if (! empty($hairColor)) {
            $hair = implode('', $hairColor);
            $meta_query[] = [
                'key' => 'model_hair_color',
                'value' => $hairColor,
                'compare' => 'IN'
            ];
        }

        if ($checkboxVideoValue === 'checked') {
            $meta_query[] = [
                'key' => 'model_has_video',
                'value' => '1',
                'compare' => '='
            ];
        }

        if ($checkboxValue === 'checked') {
            $meta_query[] = [
                'key' => 'model_verified',
                'value' => '1',
                'compare' => '='
            ];
        }

        $args['meta_query'] = $meta_query;

        $tax_query = [
            'relation' => 'AND',
            [
                'taxonomy' => 'services',
                'field' => 'slug',
                'terms' => ($services !== 'all') ? $services : ''
            ],
            [
                'taxonomy' => 'area',
                'field' => 'slug',
                'terms' => ($area !== 'all') ? $area : ''
            ],
            [
                'taxonomy' => 'metro',
                'field' => 'slug',
                'terms' => ($metro !== 'all') ? $metro : ''
            ],
        ];

        if ($acf_city_id) {
            $tax_query[] = [
                'taxonomy' => 'city',
                'field'    => 'term_id',
                'terms'    => $acf_city_id,
            ];
        }

        $args['tax_query'] = array_filter($tax_query, function ($tax) {
            return !empty($tax['terms']);
        });

        $servicesString = is_array($services) ? implode('', $services) : $services;
        $areaString = is_array($area) ? implode('', $area) : $area;
        $metroString = is_array($metro) ? implode('', $metro) : $metro;

        $lang = apply_filters('wpml_current_language', null);

        $cache_key = 'filter_results_' . $lang . '_' . $paged . $posts_per_page . $selectedStyle . $price_1 . $price_2 .
            $price_night . $height . $weight . $age . $checkboxVideoValue . $checkboxValue . $bust .
            $hair . $servicesString . $areaString . $metroString;

        $cached_results = get_transient($cache_key);

        if (false === $cached_results) {
            $query = new WP_Query($args);
            ob_start();

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    get_template_part('template-parts/templates-models-block/template_' . $selectedStyle);
                }
                wp_reset_postdata();
            }

            $cached_results = ob_get_clean();

            set_transient($cache_key, $cached_results, HOUR_IN_SECONDS);
        }
        echo $cached_results;
        wp_die();
    }

    public static function toggleCheckboxHasVideo($post_id): void
    {
        if (get_post_type($post_id) === 'models') {
            $photos = get_field('model_photos', $post_id);
            $has_video = false;

            if (! empty($photos)) {
                foreach ($photos as $photo) {
                    $mime_type = wp_check_filetype(get_attached_file($photo))['type'];
                    if (str_contains($mime_type, 'video')) {
                        $has_video = true;
                        break;
                    }
                }
            }

            if ($has_video) {
                update_field('model_has_video', true, $post_id);
                $results[] = $post_id;
            }
        }
    }
}
