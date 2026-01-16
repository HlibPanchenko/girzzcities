<?php

namespace ESC\Luna\Modules;

use WP_Query;

class CitiesModule
{
    public static function registerHooks(): void
    {
        add_filter('post_type_link', [self::class, 'replaceCityPlaceholderInPermalink'], 10, 2);

        add_filter('term_link', [self::class, 'replaceOptionsTermLink'], 10, 3);
        add_filter('term_link', [self::class, 'replaceServicesTermLink'], 10, 3);
        add_filter('term_link', [self::class, 'replaceMetroTermLink'], 10, 3);
        add_filter('term_link', [self::class, 'replaceAreaTermLink'], 10, 3);

        add_action('init', [self::class, 'registerRewriteRules']);
        add_filter('get_custom_logo', [self::class, 'replaceLogoLink']);

//        add_action('save_post', [self::class, 'saveCityContent']);

//        add_action('city_edit_form_fields', [self::class, 'showCityContentInTermEditor']);

        add_action('template_redirect', [self::class, 'redirectCityTaxonomy']);
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

    /**
     * ✅ Area: /city/area/term/
     */
    public static function replaceAreaTermLink($url, $term, $taxonomy)
    {
        if ($taxonomy === 'area') {
            $ancestors = get_ancestors($term->term_id, 'area');
            $ancestors = array_reverse($ancestors);

            $slugs = [];
            foreach ($ancestors as $ancestor_id) {
                $ancestor = get_term($ancestor_id, 'area');
                if ($ancestor && !is_wp_error($ancestor)) {
                    $slugs[] = $ancestor->slug;
                }
            }
            $slugs[] = $term->slug;

            // ✅ Главный родитель = город
            $city = array_shift($slugs);

            return home_url("/{$city}/area/" . implode('/', $slugs) . "/");
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

            // ✅ Area taxonomy: /city/area/term/
            add_rewrite_rule(
                '^(' . $cities_regex . ')/area/(.+)/?$',
                'index.php?taxonomy=area&area=$matches[2]&city=$matches[1]',
                'top'
            );

            // Пагинация для таксономии city
            add_rewrite_rule(
                '^(' . $cities_regex . ')/page/([0-9]{1,})/?$',
                'index.php?taxonomy=city&term=$matches[1]&paged=$matches[2]',
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

        // ✅ Иерархическая area: /city/area/term/ и /city/area/parent/child/
        $areaCities = get_terms([
            'taxonomy'   => 'area',
            'hide_empty' => false,
            'parent'     => 0,
            'fields'     => 'slugs',
        ]);

        if (!empty($areaCities) && !is_wp_error($areaCities)) {
            $areaCitiesRegex = implode('|', array_map('preg_quote', $areaCities));

            add_rewrite_rule(
                '^(' . $areaCitiesRegex . ')/area/(.+)/?$',
                'index.php?taxonomy=area&area=$matches[2]',
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

    public static function get_current_city_slug() {
        global $wp;

        // Берем первый сегмент URL
        $path     = trim($wp->request ?? '', '/');
        $segments = $path !== '' ? explode('/', $path) : [];
        $city_from_url = isset($segments[0]) ? sanitize_title($segments[0]) : '';

        // Список всех городов (slug)
        $cities = get_terms([
                'taxonomy'   => 'city',
                'hide_empty' => false,
                'fields'     => 'slugs',
        ]);

        // Город только из URL. Если в URL нет города, значит "без города"
        $current_city = in_array($city_from_url, (array) $cities, true) ? $city_from_url : '';

        // Куку ставим только когда город есть в URL
        if ($current_city && (!isset($_COOKIE['selected_city']) || $_COOKIE['selected_city'] !== $current_city)) {
            setcookie('selected_city', $current_city, time() + 30 * DAY_IN_SECONDS, '/');
            $_COOKIE['selected_city'] = $current_city; // доступно в этом же запросе
        }

        return $current_city;
    }

    public static function saveCityContent($post_id): void
    {
        if (get_post_type($post_id) !== 'city-content') return;

        $linked_city = get_field('linked_city', $post_id);

        if (is_array($linked_city)) {
            $linked_city = reset($linked_city);
        }

        if ($linked_city) {
            $content = get_post_field('post_content', $post_id);
            update_term_meta($linked_city, 'city_content', $content);

            error_log("✅ Term meta updated for term_id={$linked_city}");
        }
    }

    public static function showCityContentInTermEditor($term)
    {
        $city_content = get_term_meta($term->term_id, 'city_content', true);

        $linked_post = null;
        $query = new WP_Query([
            'post_type' => 'city-content',
            'meta_query' => [
                [
                    'key' => 'linked_city',
                    'value' => '"' . $term->term_id . '"',
                    'compare' => 'LIKE'
                ]
            ],
            'post_status' => 'any',
            'posts_per_page' => 1,
            'fields' => 'ids'
        ]);

        if ($query->have_posts()) {
            $linked_post = $query->posts[0];
        }

        ?>
        <tr class="form-field">
            <th scope="row">
                <label for="city_content_preview">Контент города</label>
            </th>
            <td>
                <?php if ($city_content): ?>
                    <div style="padding:10px; border:1px solid #ccc; background:#fff; max-height:250px; overflow:auto;">
                        <?php echo wpautop(wp_kses_post($city_content)); ?>
                    </div>
                <?php else: ?>
                    <p><em>Для этого города ещё не синхронизирован контент.</em></p>
                <?php endif; ?>

                <?php if ($linked_post): ?>
                    <p style="margin-top:8px;">
                        ✅ <strong>Этот контент редактируется через "Контент Городов".</strong><br>
                        Чтобы изменить текст, откройте запись:
                        <a href="<?php echo get_edit_post_link($linked_post); ?>" target="_blank">
                            Редактировать "Контент Городов"
                        </a>
                    </p>
                <?php else: ?>
                    <p style="margin-top:8px; color: #c00;">
                        ❌ <strong>Для этого города не найден связанный пост "Контент Городов".</strong><br><br>
                        <strong>Пошаговая инструкция:</strong><br>
                        1️⃣ Перейдите в <a href="<?php echo admin_url('edit.php?post_type=city-content'); ?>" target="_blank">CPT City Content</a>.<br>
                        2️⃣ Нажмите "Добавить новую".<br>
                        3️⃣ В блоке ACF выберите этот город в поле "Привязанный город".<br>
                        4️⃣ Заполните контент в редакторе Gutenberg.<br>
                        5️⃣ Сохраните запись – контент автоматически появится на странице города.
                    </p>
                <?php endif; ?>
            </td>
        </tr>
        <style>
            #tag-description, tr.form-field.term-description-wrap {
                display: none;
            }
        </style>
        <?php
    }

    public static function redirectCityTaxonomy(): void
    {
        if (is_tax('city')) {
            $term = get_queried_object();
            if (!empty($term) && isset($term->slug)) {
                $current_url = home_url($_SERVER['REQUEST_URI']);

                if (strpos($_SERVER['REQUEST_URI'], '/city/') === 0) {
                    $clean_url = home_url('/' . $term->slug . '/');

                    if (trailingslashit($current_url) !== trailingslashit($clean_url)) {
                        wp_safe_redirect($clean_url, 301);
                        exit;
                    }
                }
            }
        }
    }
}
