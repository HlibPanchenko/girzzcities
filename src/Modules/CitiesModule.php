<?php

namespace ESC\Luna\Modules;

class CitiesModule
{
    public static function registerHooks(): void
    {
        add_filter('post_type_link', [self::class, 'replaceCityPlaceholderInPermalink'], 10, 2);
        add_action('init', [self::class, 'registerRewriteTag']);
    }

    public static function replaceCityPlaceholderInPermalink($post_link, $post)
    {
        if ($post->post_type !== 'city-page') return $post_link;

        $terms = get_the_terms($post->ID, 'city');
        if (!empty($terms) && !is_wp_error($terms)) {
            $city_slug = $terms[0]->slug;
            $post_link = str_replace('%city%', $city_slug, $post_link);
        }

        return $post_link;
    }

    public static function registerRewriteTag(): void
    {
        add_rewrite_tag('%city%', '([^/]+)');
    }
}
