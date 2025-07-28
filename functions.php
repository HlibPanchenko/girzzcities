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









