<?php

namespace ESC\Luna\Modules;

class WpmlModule
{
    public static function registerHooks(): void
    {
        add_action('init', [self::class, 'registerWpmlStrings']);
    }

    public static function registerWpmlStrings(): void
    {
        if ( function_exists( 'icl_register_string' ) ) {
            icl_register_string( 'Kirki', 'Telephone text', get_theme_mod('header_tel_text') );
            icl_register_string( 'Kirki', 'Telephone text mobile', get_theme_mod('header_tel_text--mobile') );
            icl_register_string( 'Kirki', 'Telegram text', get_theme_mod('header_telegram_text') );
            icl_register_string( 'Kirki', 'Telegram text mobile', get_theme_mod('header_telegram_text--mobile') );
            icl_register_string( 'Kirki', 'Whatsapp text', get_theme_mod('header_whatsapp_text') );
            icl_register_string( 'Kirki', 'Whatsapp text mobile', get_theme_mod('header_whatsapp_text--mobile') );
            icl_register_string( 'Kirki', 'Hint Text', get_theme_mod('contacts_hint') );
            icl_register_string( 'Kirki', 'Text 404', get_theme_mod('page_404_text') );
            icl_register_string( 'Kirki', 'Toc Text', get_theme_mod('toc_text') );
        }
    }
}
