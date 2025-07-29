<?php

namespace ESC\Luna\Modules;

class CitiesModule
{
    public static function registerHooks(): void
    {
        add_filter('post_type_link', [self::class, 'replaceCityPlaceholderInPermalink'], 10, 2);
        add_filter('term_link', [self::class, 'replaceOptionsTermLink'], 10, 3); // ✅ добавили фильтр для options
        add_action('init', [self::class, 'registerRewriteRules']);
        add_filter('get_custom_logo', [self::class, 'replaceLogoLink']);
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

    /**
     * ✅ 3️⃣ Переписываем ссылки для options: /city/options/term/
     * Город = родительский термин options
     */
    public static function replaceOptionsTermLink($url, $term, $taxonomy)
    {
        if ($taxonomy === 'options' && $term->parent) {
            $parent = get_term($term->parent, 'options');
            if ($parent && !is_wp_error($parent)) {
                return home_url("/{$parent->slug}/options/{$term->slug}/");
            }
        }
        return $url;
    }

    public static function registerRewriteRules(): void
    {
        add_rewrite_tag('%city%', '([^/]+)');

        // ✅ Старая логика для таксы city
        $cities = get_terms([
            'taxonomy'   => 'city',
            'hide_empty' => false,
            'fields'     => 'slugs',
        ]);

        if (!empty($cities) && !is_wp_error($cities)) {
            $cities_regex = implode('|', array_map('preg_quote', $cities));

            // ✅ Модели: /city/models/slug/
            add_rewrite_rule(
                '^(' . $cities_regex . ')/models/([^/]+)/?$',
                'index.php?post_type=models&name=$matches[2]&city=$matches[1]',
                'top'
            );

            // ✅ City pages: /city/page/
            add_rewrite_rule(
                '^(' . $cities_regex . ')/(?!models|options)([^/]+)/?$',
                'index.php?post_type=city-page&name=$matches[2]&city=$matches[1]',
                'top'
            );

            // ✅ Options taxonomy (вариант с отдельной таксой city): /city/options/term/
            add_rewrite_rule(
                '^(' . $cities_regex . ')/options/([^/]+)/?$',
                'index.php?taxonomy=options&term=$matches[2]&city=$matches[1]',
                'top'
            );
        }

        // ✅ 4️⃣ Rewrite для иерархической таксономии options, где город = родитель
        $optionCities = get_terms([
            'taxonomy'   => 'options',
            'hide_empty' => false,
            'parent'     => 0,
            'fields'     => 'slugs',
        ]);

        if (!empty($optionCities) && !is_wp_error($optionCities)) {
            $optionCitiesRegex = implode('|', array_map('preg_quote', $optionCities));

            add_rewrite_rule(
                '^(' . $optionCitiesRegex . ')/options/([^/]+)/?$',
                'index.php?taxonomy=options&options=$matches[2]',
                'top'
            );
        }
    }

    public static function replaceLogoLink($html)
    {
        if (!empty($_COOKIE['selected_city'])) {
            $city = sanitize_title($_COOKIE['selected_city']);
            // Заменяем href="/" на href="/city/"
            $html = preg_replace(
                '/href="[^"]+"/',
                'href="' . home_url('/' . $city . '/') . '"',
                $html
            );
        }
        return $html;
    }
}
