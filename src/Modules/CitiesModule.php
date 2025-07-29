<?php

namespace ESC\Luna\Modules;

class CitiesModule
{
    public static function registerHooks(): void
    {
        add_filter('post_type_link', [self::class, 'replaceCityPlaceholderInPermalink'], 10, 2);

        // ✅ Подменяем ссылки для options и services
        add_filter('term_link', [self::class, 'replaceOptionsTermLink'], 10, 3);
        add_filter('term_link', [self::class, 'replaceServicesTermLink'], 10, 3);
        add_filter('term_link', [self::class, 'replaceMetroTermLink'], 10, 3);

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
     * ✅ Options: /city/options/term/
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

    /**
     * ✅ Services: /city/services/term/
     */
    public static function replaceServicesTermLink($url, $term, $taxonomy)
    {
        if ($taxonomy === 'services') {
            $ancestors = get_ancestors($term->term_id, 'services');
            $ancestors = array_reverse($ancestors);

            $slugs = [];
            foreach ($ancestors as $ancestor_id) {
                $ancestor = get_term($ancestor_id, 'services');
                if ($ancestor && !is_wp_error($ancestor)) {
                    $slugs[] = $ancestor->slug;
                }
            }
            $slugs[] = $term->slug;

            // ✅ Первый элемент массива $slugs = главный родитель = город
            $city = array_shift($slugs);

            return home_url("/{$city}/services/" . implode('/', $slugs) . "/");
        }
        return $url;
    }

    /**
     * ✅ Services: /city/metro/term/
     */
    public static function replaceMetroTermLink($url, $term, $taxonomy)
    {
        if ($taxonomy === 'metro') {
            $ancestors = get_ancestors($term->term_id, 'metro');
            $ancestors = array_reverse($ancestors);

            $slugs = [];
            foreach ($ancestors as $ancestor_id) {
                $ancestor = get_term($ancestor_id, 'metro');
                if ($ancestor && !is_wp_error($ancestor)) {
                    $slugs[] = $ancestor->slug;
                }
            }
            $slugs[] = $term->slug;

            // ✅ Главный родитель = город
            $city = array_shift($slugs);

            return home_url("/{$city}/metro/" . implode('/', $slugs) . "/");
        }
        return $url;
    }

    public static function registerRewriteRules(): void
    {
        add_rewrite_tag('%city%', '([^/]+)');

        // ✅ Таксономия city
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
                '^(' . $cities_regex . ')/(?!models|options|services)([^/]+)/?$',
                'index.php?post_type=city-page&name=$matches[2]&city=$matches[1]',
                'top'
            );

            // ✅ Options taxonomy: /city/options/term/
            add_rewrite_rule(
                '^(' . $cities_regex . ')/options/([^/]+)/?$',
                'index.php?taxonomy=options&term=$matches[2]&city=$matches[1]',
                'top'
            );

            // ✅ Metro taxonomy: /city/metro/term/
            add_rewrite_rule(
                '^(' . $cities_regex . ')/metro/(.+)/?$',
                'index.php?taxonomy=metro&metro=$matches[2]&city=$matches[1]',
                'top'
            );

            // ✅ Services taxonomy: /city/services/term/
            add_rewrite_rule(
                '^(' . $cities_regex . ')/services/(.+)/?$',
                'index.php?taxonomy=services&services=$matches[2]&city=$matches[1]',
                'top'
            );

        }

        // ✅ Иерархическая options: /city/options/term/
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

        // ✅ Иерархическая services: /city/services/term/ и /city/services/parent/child/
        $serviceCities = get_terms([
            'taxonomy'   => 'services',
            'hide_empty' => false,
            'parent'     => 0,
            'fields'     => 'slugs',
        ]);

        if (!empty($serviceCities) && !is_wp_error($serviceCities)) {
            $serviceCitiesRegex = implode('|', array_map('preg_quote', $serviceCities));

            add_rewrite_rule(
                '^(' . $serviceCitiesRegex . ')/services/(.+)/?$',
                'index.php?taxonomy=services&services=$matches[2]',
                'top'
            );
        }

        // ✅ Иерархическая metro: /city/metro/term/ и /city/metro/parent/child/
        $metroCities = get_terms([
            'taxonomy'   => 'metro',
            'hide_empty' => false,
            'parent'     => 0,
            'fields'     => 'slugs',
        ]);

        if (!empty($metroCities) && !is_wp_error($metroCities)) {
            $metroCitiesRegex = implode('|', array_map('preg_quote', $metroCities));

            add_rewrite_rule(
                '^(' . $metroCitiesRegex . ')/metro/(.+)/?$',
                'index.php?taxonomy=metro&metro=$matches[2]',
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
