<?php

namespace ESC\Luna\Modules;

class AcfModule
{
    public static function registerHooks(): void
    {
        add_action('acf/init', [self::class, 'registerAcfOptions']);
    }

    public static function registerAcfOptions(): void
    {
        if (!function_exists('acf_add_options_page')) {
            return;
        }

        $subPages = [
            ['page_title' => __('Header Options'), 'menu_title' => __('Header Menu')],
        ];

        foreach ($subPages as $page) {
            acf_add_options_page([
                'page_title'  => $page['page_title'],
                'menu_title'  => $page['menu_title'],
                'parent_slug' => 'themes.php',
            ]);
        }
    }
}
