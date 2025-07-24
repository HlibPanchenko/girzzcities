<?php

use ESC\Luna\EscTheme;

require_once __DIR__ . '/vendor/autoload.php';


if (! defined('THEME_VERSION')) {
    define('THEME_VERSION', '1.0.36');
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (class_exists('Kirki')) {
    require_once('config/customizer.php');
}

EscTheme::initHooks();

/*
 * For cases when WPML is not installed:
 * Если WPML есть, будет использоваться настоящая icl_t().
 * Если WPML нет, будет использоваться твоя заглушка (fallback), и ошибок не будет.
 * */
if (!function_exists('icl_t')) {
    function icl_t($context, $name, $value) {
        return $value;
    }
}


add_filter('post_type_link', 'replace_city_placeholder_in_permalink', 10, 2);

function replace_city_placeholder_in_permalink($post_link, $post) {
    if ($post->post_type !== 'city_page') return $post_link;

    $terms = get_the_terms($post->ID, 'city');
    if (!empty($terms) && !is_wp_error($terms)) {
        $city_slug = $terms[0]->slug;
        $post_link = str_replace('%city%', $city_slug, $post_link);
    }

    return $post_link;
}

add_action('init', function () {
    add_rewrite_tag('%city%', '([^/]+)');
});







