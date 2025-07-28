<?php

namespace ESC\Luna\Modules;

class CitiesModule
{
    public static function registerHooks(): void
    {
        add_filter('post_type_link', [self::class, 'replaceCityPlaceholderInPermalink'], 10, 2);
        add_action('init', [self::class, 'registerRewriteRules']);
    }

    public static function replaceCityPlaceholderInPermalink($post_link, $post)
    {
        if (!in_array($post->post_type, ['city-page', 'models'], true)) {
            return $post_link;
        }

        $terms = get_the_terms($post->ID, 'city');
        if (!empty($terms) && !is_wp_error($terms)) {
            $city_slug = $terms[0]->slug;

            if ($post->post_type === 'models') {
                // для моделей подставляем /city/models/slug/
                $post_link = home_url("/{$city_slug}/models/{$post->post_name}/");
            } else {
                // для city-page оставляем /city/slug/
                $post_link = str_replace('%city%', $city_slug, $post_link);
            }
        }

        return $post_link;
    }

    public static function registerRewriteRules(): void
    {
        add_rewrite_tag('%city%', '([^/]+)');

        $cities = get_terms([
            'taxonomy'   => 'city',
            'hide_empty' => false,
            'fields'     => 'slugs',
        ]);

        if (!empty($cities) && !is_wp_error($cities)) {
            $cities_regex = implode('|', array_map('preg_quote', $cities));

            // ✅ Сначала добавляем models с исключением
            add_rewrite_rule(
                '^(' . $cities_regex . ')/models/([^/]+)/?$',
                'index.php?post_type=models&name=$matches[2]&city=$matches[1]',
                'top'
            );

            // ✅ Для city-page запрещаем models как первый сегмент после города
            add_rewrite_rule(
                '^(' . $cities_regex . ')/(?!models)([^/]+)/?$',
                'index.php?post_type=city-page&name=$matches[2]&city=$matches[1]',
                'top'
            );
        }
    }

}
