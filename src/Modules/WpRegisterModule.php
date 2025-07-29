<?php

namespace ESC\Luna\Modules;
use Kirki\Compatibility\Kirki;

class WpRegisterModule
{
    public static function registerHooks(): void
    {
        add_action('wp_enqueue_scripts', [__CLASS__, 'enqueueScripts']);

        add_action('after_setup_theme', [__CLASS__, 'registerThemeSupports']);

        add_action('init', [__CLASS__, 'registerCityMenus']);

        add_action('widgets_init', [__CLASS__, 'registerSidebars']);

        add_action('upload_mimes', [__CLASS__, 'addSvgSupport']);

        add_action('wp_default_scripts', [__CLASS__, 'removeJQueryMigrate']);

        add_action('init', [__CLASS__, 'setCookies']);

        // Hide admin-menu elements
        add_action('admin_menu', [__CLASS__, 'restrictEditorAccess'], 10);
        add_action('admin_init', [__CLASS__, 'blockEditorAdminPages']);

        if (function_exists('acf_register_block_type')) {
            add_action('acf/init', [__CLASS__, 'registerAcfBlockTypes']);
        }
    }

    public static function enqueueScripts(): void
    {
        wp_enqueue_style(
            'fancybox-styles',
            get_template_directory_uri() . '/assets/css/jquery.fancybox.min.css',
            '',
            THEME_VERSION
        );
        wp_enqueue_style(
            'swiper-styles',
            get_template_directory_uri() . '/assets/css/swiper-bundle.min.css',
            '',
            THEME_VERSION
        );
        wp_enqueue_style(
            'zuck-styles',
            get_template_directory_uri() . '/assets/css/zuck.min.css',
            '',
            THEME_VERSION
        );
        wp_enqueue_style('girls-style', get_stylesheet_uri(), '', THEME_VERSION);
        wp_enqueue_script('jquery');
        wp_enqueue_script(
            'fancybox-scripts',
            get_template_directory_uri() . '/assets/js/modules/jquery.fancybox.min.js',
            'jquery',
            THEME_VERSION,
            true
        );
        wp_enqueue_script(
            'swiper-scripts',
            get_template_directory_uri() . '/assets/js/modules/swiper-bundle.min.js',
            'jquery',
            THEME_VERSION,
            true
        );
        wp_enqueue_script(
            'lazy-scripts',
            get_template_directory_uri() . '/assets/js/modules/jquery.lazy.min.js',
            'jquery',
            THEME_VERSION,
            true
        );
        wp_enqueue_script(
            'zuck-scripts',
            get_template_directory_uri() . '/assets/js/modules/zuck.js',
            'typescript',
            THEME_VERSION,
            true
        );
        wp_enqueue_script(
            'girls-scripts',
            get_template_directory_uri() . '/assets/js/scripts.min.js',
            'jquery',
            THEME_VERSION,
            true
        );

        $cities = get_terms([
            'taxonomy'   => 'city',
            'hide_empty' => false,
        ]);
        $city_slugs = wp_list_pluck($cities, 'slug');

        $switcher_city_text_g = Kirki::get_option('switcher_text') ?? 'Город';

        wp_localize_script('girls-scripts', 'my_ajax_object', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'site_currency' =>  get_field('site_currency', 'option') ? get_field('site_currency', 'option') :'₽',
            'availableCities'=> $city_slugs,
            'switcherCitiesText'=> $switcher_city_text_g,
        ]);
    }

    public static function registerThemeSupports(): void
    {
        add_theme_support('post-thumbnails');
        add_theme_support('title-tag');
        add_theme_support('customize-selective-refresh-widgets');
        add_theme_support(
            'html5',
            [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            ]
        );

        $base_locations = [
            'header_menu'        => 'Header Menu',
            'footer_menu'        => 'Footer Menu',
            'header_mobile_menu' => 'Header Mobile Menu',
        ];

        register_nav_menus($base_locations);

        add_theme_support(
            'custom-logo',
            [
                'height'      => 250,
                'width'       => 250,
                'flex-width'  => true,
                'flex-height' => true,
            ]
        );
    }

    public static function registerCityMenus(): void
    {
        $base_locations = [
            'header_menu'        => 'Header Menu',
            'footer_menu'        => 'Footer Menu',
            'header_mobile_menu' => 'Header Mobile Menu',
        ];

        register_nav_menus($base_locations);

        $cities = get_terms([
            'taxonomy'   => 'city',
            'hide_empty' => false,
        ]);

        if (!empty($cities) && !is_wp_error($cities)) {
            $dynamic_menus = [];

            foreach ($cities as $city) {
                foreach ($base_locations as $key => $label) {
                    $dynamic_key = $key . '_' . $city->slug;
                    $dynamic_menus[$dynamic_key] = $label . ' (' . $city->name . ')';
                }
            }

            if ($dynamic_menus) {
                register_nav_menus($dynamic_menus);
            }
        }
    }

    public static function registerSidebars(): void
    {
        register_sidebar([
            'name' => 'Header Phone Widget',
            'id' => 'header-1',
            'description' => '1-nd place',
            'before_widget' => '<div class="phone-widget">',
            'after_widget' => '</div>',
            'before_title' => '<h2>',
            'after_title' => '</h2>',
        ]);

        register_sidebar([
            'name' => 'Footer Description Widget',
            'id' => 'footer-1',
            'description' => '1-nd place',
            'before_widget' => '<div class="footer-widget">',
            'after_widget' => '</div>',
            'before_title' => '<h2>',
            'after_title' => '</h2>',
        ]);

        register_sidebar([
            'name'          => 'Footer menu 1',
            'id'            => "footer-menu-1",
            'description'   => '',
            'class'         => '',
            'before_widget' => '<div class="menubox">',
            'after_widget'  => "</div>",
            'before_title'  => '<p class="menubox-title">',
            'after_title'   => "</p>",
        ]);

        register_sidebar([
            'name'          => 'Footer menu 2',
            'id'            => "footer-menu-2",
            'description'   => '',
            'class'         => '',
            'before_widget' => '<div class="menubox">',
            'after_widget'  => "</div>",
            'before_title'  => '<p class="menubox-title">',
            'after_title'   => "</p>",
        ]);

        register_sidebar([
            'name'          => 'Footer menu 3',
            'id'            => "footer-menu-3",
            'description'   => '',
            'class'         => '',
            'before_widget' => '<div class="menubox">',
            'after_widget'  => "</div>",
            'before_title'  => '<p class="menubox-title">',
            'after_title'   => "</p>",
        ]);

        register_sidebar([
            'name'          => 'Footer menu 4',
            'id'            => "footer-menu-4",
            'description'   => '',
            'class'         => '',
            'before_widget' => '<div class="menubox">',
            'after_widget'  => "</div>",
            'before_title'  => '<p class="menubox-title">',
            'after_title'   => "</p>",
        ]);

        register_sidebar([
            'name'          => 'Footer menu 5',
            'id'            => "footer-menu-5",
            'description'   => '',
            'class'         => '',
            'before_widget' => '<div class="menubox">',
            'after_widget'  => "</div>",
            'before_title'  => '<p class="menubox-title">',
            'after_title'   => "</p>",
        ]);

    }

    public static function addSvgSupport($allowed): array
    {
        if (!current_user_can('manage_options')) {
            return $allowed;
        }
        $allowed['svg'] = 'image/svg+xml';
        return $allowed;
    }

    public static function registerAcfBlockTypes(): void
    {
        acf_register_block_type([
            'name' => 'popular-categories-block',
            'title' => 'Popular Categories Block',
            'description' => 'A block for displaying popular categories',
            'render_template' => 'template-parts/blocks/popular-categories-block.php',
            'icon' => 'list-view',
            'keywords' => 'popular categories'
        ]);

        acf_register_block_type([
            'name' => 'cta-block',
            'title' => 'CTA Block',
            'description' => 'A block for CTA',
            'render_template' => 'template-parts/blocks/cta-block.php',
            'icon' => 'list-view',
            'keywords' => 'cta'
        ]);


        acf_register_block_type([
            'name' => 'cards-block',
            'title' => 'Cards Block',
            'description' => '',
            'render_template' => 'template-parts/blocks/cards-block.php',
            'icon' => 'list-view',
            'keywords' => 'card'
        ]);

        acf_register_block_type([
            'name' => 'statistics-block',
            'title' => 'Statistics Block',
            'description' => 'A block for displaying statistics block',
            'render_template' => 'template-parts/blocks/statistics-block.php',
            'icon' => 'list-view',
            'keywords' => 'statistics'
        ]);

        acf_register_block_type([
            'name' => 'models-block',
            'title' => 'Models Block',
            'description' => 'A block for displaying models',
            'render_template' => 'template-parts/blocks/models-block.php',
            'icon' => 'list-view',
            'keywords' => 'models'
        ]);

        acf_register_block_type([
            'name' => 'models-filter-block',
            'title' => 'Models Filter Block',
            'description' => 'A block for displaying all models filter',
            'render_template' => 'template-parts/blocks/models-filter-block/models-filter-block.php',
            'icon' => 'list-view',
            'keywords' => 'models'
        ]);

        acf_register_block_type([
            'name' => 'advantages-block',
            'title' => __('Advantages Block'),
            'desciption' => __('A custom advantages block'),
            'render_template' => 'template-parts/blocks/advantages-block.php',
            'icon' => "ellipsis",
            'keywords' => ['advantages', 'product']
        ]);

        acf_register_block_type([
            'name' => 'hero-sliders',
            'title' => __('Hero Slider Block'),
            'desciption' => __('A custom sliders block'),
            'render_template' => 'template-parts/blocks/hero-sliders.php',
            'icon' => "slides",
            'keywords' => ['sliders', 'product']
        ]);

        acf_register_block_type([
            'name' => 'hero',
            'title' => __('Hero Block'),
            'description' => __('A custom hero block'),
            'render_template' => 'template-parts/blocks/hero.php',
            'keywords' => ['hero']
        ]);

        acf_register_block_type([
            'name' => 'bg-image-block',
            'title' => __('Background Image Block'),
            'desciption' => __('A custom background image block'),
            'render_template' => 'template-parts/blocks/background-image.php',
            'icon' => "format-image",
            'keywords' => ['bg-image', 'product']
        ]);

        acf_register_block_type([
            'name' => 'contact-block',
            'title' => __('Contact Block'),
            'desciption' => __('A custom contact block'),
            'render_template' => 'template-parts/blocks/contact-block.php',
            'icon' => "phone",
            'keywords' => ['contact', 'product']
        ]);

        acf_register_block_type([
            'name' => 'metros-block',
            'title' => __('Metros Block'),
            'desciption' => __('A custom metros block'),
            'render_template' => 'template-parts/blocks/metros-block.php',
            'icon' => 'list-view',
            'keywords' => ['metro', 'product']
        ]);

        acf_register_block_type([
            'name' => 'areas-block',
            'title' => __('Areas Block'),
            'desciption' => __('A custom areas block'),
            'render_template' => 'template-parts/blocks/areas-block.php',
            'icon' => 'list-view',
            'keywords' => ['area', 'product']
        ]);

        acf_register_block_type([
            'name' => 'services-block',
            'title' => __('Services Block'),
            'desciption' => __('A custom services block'),
            'render_template' => 'template-parts/blocks/services-block.php',
            'icon' => 'list-view',
            'keywords' => ['service', 'product']
        ]);

        acf_register_block_type([
            'name' => 'last-post-block',
            'title' => __('Last Post Block'),
            'desciption' => __('A custom last post block'),
            'render_template' => 'template-parts/blocks/last-post-block.php',
            'icon' => 'screenoptions',
            'keywords' => ['blog', 'post']
        ]);

        acf_register_block_type([
            'name' => 'stories-block',
            'title' => __('Stories Block'),
            'desciption' => __('A custom stories block'),
            'render_template' => 'template-parts/blocks/stories-block.php',
            'icon' => 'video-alt2',
            'keywords' => ['story', 'models']
        ]);

        acf_register_block_type([
            'name' => 'two-cards-block',
            'title' => __('Two Cards Block'),
            'desciption' => __('A custom two cards block'),
            'render_template' => 'template-parts/blocks/two-cards-block.php',
            'icon' => 'list-view',
            'keywords' => ['two cards', 'cards']
        ]);

        acf_register_block_type([
            'name' => 'testimonials-block',
            'title' => __('Testimonials Block'),
            'description' => __('A custom testimonials block'),
            'render_template' => 'template-parts/blocks/testimonials-block.php',
            'icon' => 'list-view',
            'keywords' => ['testimonials', 'testimonial']
        ]);

        acf_register_block_type([
            'name' => 'list-block',
            'title' => __('List Block'),
            'description' => __('A custom list block'),
            'render_template' => 'template-parts/blocks/list-block.php',
            'icon' => 'list-view',
            'keywords' => ['list', 'advantages', 'pros']
        ]);

        acf_register_block_type([
            'name' => 'faq-block',
            'title' => __('FAQ Block'),
            'description' => __('A custom FAQ block'),
            'render_template' => 'template-parts/blocks/faq-block.php',
            'icon' => 'list-view',
            'keywords' => ['accordion', 'faq', 'questions']
        ]);

        acf_register_block_type([
            'name' => 'icons-block',
            'title' => __('Icons Block'),
            'description' => __('A custom Icons block'),
            'render_template' => 'template-parts/blocks/icons-block.php',
            'icon' => 'list-view',
            'keywords' => ['icons', 'footer icons', 'cards payment']
        ]);

        acf_register_block_type([
            'name' => 'posts-grid',
            'title' => __('Posts Block'),
            'description' => __('A custom Posts block'),
            'render_template' => 'template-parts/blocks/posts-grid.php',
            'icon' => 'list-view',
            'keywords' => ['posts', 'post', 'posts grid']
        ]);

        acf_register_block_type([
            'name' => 'cities-grid',
            'title' => __('Cities Block'),
            'description' => __('A custom Cities block'),
            'render_template' => 'template-parts/blocks/cities-grid.php',
            'icon' => 'list-view',
            'keywords' => ['cities', 'city']
        ]);

        acf_register_block_type([
            'name' => 'options-block',
            'title' => __('Options Block'),
            'desciption' => __('A custom options block'),
            'render_template' => 'template-parts/blocks/options-block.php',
            'icon' => 'screenoptions',
            'keywords' => ['option', 'models']
        ]);
    }

    public static function removeJQueryMigrate($scripts): void
    {
        if (! is_admin() && isset($scripts->registered['jquery'])) {
            $script = $scripts->registered['jquery'];
            if ($script->deps) {
                $script->deps = array_diff($script->deps, ['jquery-migrate']);
            }
        }
    }

    public static function restrictEditorAccess(): void
    {
        if (current_user_can('editor') && !current_user_can('administrator')) {
            remove_menu_page('plugins.php');
            remove_menu_page('options-general.php');

            // Удаляем доступ к инструментам
            remove_menu_page('tools.php');

            // Удаляем доступ к внешнему виду
            remove_menu_page('themes.php');

            // Удаляем доступ к пользователям
            remove_menu_page('users.php');
        }
    }

    public static function blockEditorAdminPages(): void
    {
        if (current_user_can('editor') && !current_user_can('administrator')) {
            $restricted_pages = [
                'plugins.php',
                'options-general.php',
                'tools.php',
                'themes.php',
                'users.php',
                'edit.php?post_type=page',
                'edit-comments.php'
            ];

            $current_page = basename($_SERVER['PHP_SELF']);

            if (in_array($current_page, $restricted_pages)) {
                wp_die(__('У вас нет доступа к этой странице.'));
            }
        }
    }

    public static function setCookies(): void {
        if ( ! isset($_COOKIE['pll_language']) ) {
            if ( function_exists('icl_object_id') && defined('ICL_LANGUAGE_CODE') ) {
                $lang = ICL_LANGUAGE_CODE;
            } else {
                $lang = 'ru';
            }

            setcookie('pll_language', $lang, time() + WEEK_IN_SECONDS, '/');
        }

        if ( ! isset($_COOKIE['defaultCurrency']) ) {
            $currency = 'RUB';
            setcookie('defaultCurrency', $currency, time() + WEEK_IN_SECONDS, '/');
        }
    }
}
