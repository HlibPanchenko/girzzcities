<?php

namespace ESC\Luna\Modules;

class ShortcodeModule
{
    public static function registerHooks(): void
    {
        add_shortcode('year', [__CLASS__, 'yearShortcode']);
        add_shortcode('site_name', [__CLASS__, 'siteNameShortcode']);
        add_shortcode('site_city', [__CLASS__, 'siteCityShortcode']);
    }

    public static function yearShortcode(): string
    {
        return date_i18n('Y');
    }

    public static function siteNameShortcode(): string
    {
        return get_bloginfo('name');
    }

    public static function siteCityShortcode(): string
    {
        return get_field('site_city', 'option') ?: '';
    }
}