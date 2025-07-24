<?php

namespace ESC\Luna\Modules;

namespace ESC\Luna\Modules;

namespace ESC\Luna\Modules;

class MegaMenu
{
    private static array $allowed_taxonomies = ['options', 'area', 'metro', 'services'];

    public static function registerHooks(): void
    {
        add_action('wp_ajax_get_cpt_models', [__CLASS__, 'getCptModels']);
        add_action('wp_ajax_nopriv_get_cpt_models', [__CLASS__, 'getCptModels']);
    }

    public static function getCptModels(): void
    {
        if (empty($_GET['taxonomy'])) {
            error_log('Ошибка: таксономия не указана.');
            wp_send_json_error(['message' => 'Таксономия не указана.']);
            wp_die();
        }

        $taxonomy_slug = sanitize_text_field($_GET['taxonomy']);
        error_log("Получена таксономия: $taxonomy_slug");

        // Проверяем, существует ли такая таксономия в списке разрешенных
        $taxonomy = null;
        foreach (self::$allowed_taxonomies as $allowed_tax) {
            if (term_exists($taxonomy_slug, $allowed_tax)) {
                $taxonomy = $allowed_tax;
                break;
            }
        }

        if (!$taxonomy) {
            error_log("Ошибка: таксономия '$taxonomy_slug' не найдена в списке допустимых.");
            wp_send_json_error(['message' => 'Некорректная таксономия.']);
            wp_die();
        }

        error_log("Используем таксономию: $taxonomy");

        // Получаем записи CPT, связанные с данной таксономией
        $query_args = [
            'post_type'      => 'models', // CPT
            'posts_per_page' => 25, // Ограничение количества записей
            'tax_query'      => [
                [
                    'taxonomy' => $taxonomy,
                    'field'    => 'slug',
                    'terms'    => $taxonomy_slug,
                ]
            ]
        ];

        $models_query = new \WP_Query($query_args);
        error_log('SQL-запрос: ' . $models_query->request);

        if ($models_query->have_posts()) {
            $models = [];

            while ($models_query->have_posts()) {
                $models_query->the_post();

                // Получаем первую фотографию из ACF поля (по ID)
                $model_photos = get_field('model_photos');
                $model_image_id = isset($model_photos[0]) ? $model_photos[0] : ''; // ID первой фотографии
                $model_image_url = $model_image_id ? wp_get_attachment_url($model_image_id) : ''; // Получаем URL изображения по ID

                $models[] = [
                    'title'   => get_the_title(),
                    'excerpt' => get_the_excerpt(),
                    'link'    => get_permalink(),
                    'image'   => $model_image_url, // Добавляем изображение
                ];
            }

            error_log('Найдено моделей: ' . count($models));
            wp_send_json_success(['models' => $models, 'taxonomy' => $taxonomy, 'term' => $taxonomy_slug]);
        } else {
            error_log('Модели не найдены.');
            wp_send_json_success(['models' => []]);
        }

        wp_die();
    }
}


