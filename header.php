<?php

use ESC\Luna\ThemeFunctions;
use ESC\Luna\MegaMenuWalker;
use ESC\Luna\DefaultMenuWalker;
use Kirki\Compatibility\Kirki;

if (Kirki::get_option('float_header_enable') === true) {
    $header_class = 'fixed';
} else {
    $header_class = '';
}

if (Kirki::get_option('header_banner_show') === 'show') {
    $banner_class = '';
} else {
    $banner_class = 'hidden';
}

if (is_user_logged_in()) {
    $admin_class = 'admin';
} else {
    $admin_class = '';
}

$show_mega_menu = get_field('mega_menu', 'option') == "Enable";
$header_class = $show_mega_menu ? 'header--mega' : 'header--default';
$phone_enable = Kirki::get_option('contacts_phone_enable');
$telegram_enable = Kirki::get_option('contacts_telegram_enable');
$whatsapp_enable = Kirki::get_option('contacts_whatsapp_enable');
$phone = Kirki::get_option('contacts_phone');
$telegram = Kirki::get_option('contacts_telegram');
$whatsapp = Kirki::get_option('contacts_whatsapp');

$phone_text = icl_t('Kirki', 'Telephone text', Kirki::get_option('header_tel_text'));
$phone_text_mobile = icl_t('Kirki', 'Telephone text mobile', Kirki::get_option('header_tel_text--mobile'));
$telegram_text = icl_t('Kirki', 'Telegram text', Kirki::get_option('header_telegram_text'));
$telegram_text_mobile = icl_t('Kirki', 'Telegram text mobile', Kirki::get_option('header_telegram_text--mobile'));
$whatsapp_text = icl_t('Kirki', 'Whatsapp text', Kirki::get_option('header_whatsapp_text'));
$whatsapp_text_mobile = icl_t('Kirki', 'Whatsapp text mobile', Kirki::get_option('header_whatsapp_text--mobile'));


?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta name="theme-color" content="<?php echo Kirki::get_option('theme_main_color') ?>">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site zoom">
    <header id="masthead" class="site-header wrapper <?php echo $header_class; ?> <?php echo $admin_class; ?> <?php echo $header_class; ?>">
        <div class="header-wrap">
            <div class="header-banner <?php echo $banner_class ?>">
                <div class="container">
                    <?php
                    if ($phone_enable || $telegram_enable || $whatsapp_enable) {
                        ?>
                        <div class="contacts-holder">
                            <?php
                            if ($phone_enable === true) {
                                ?>
                                <a href="tel:<?php echo $phone ?>" id="phone-header" class="phone-number">
                                    <?php echo ThemeFunctions::getInlineSvg('call-button-banner'); ?>
                                    <span class="contact--desktop">
                                        <?php echo $phone_text ?>
                                    </span>
                                                        <span class="contact--mobile">
                                        <?php echo $phone_text_mobile ?>
                                    </span>
                                </a>
                                <?php
                            }

                            if ($telegram_enable) {
                                ?>
                                <a href="<?php echo $telegram ?>" class="social-link social-link--telegram" target="_blank" rel="noopener noreferrer">
                                    <?php echo ThemeFunctions::getInlineSvg('telegram-banner'); ?>
                                    <span class="contact--desktop">
                                        <?php echo $telegram_text ?>
                                    </span>
                                                        <span class="contact--mobile">
                                        <?php echo $telegram_text_mobile ?>
                                    </span>
                                </a>
                                <?php
                            }

                            if ($whatsapp_enable) {
                                ?>
                                <a href="<?php echo $whatsapp ?>" class="social-link social-link--whatsapp" target="_blank" rel="noopener noreferrer">
                                    <?php echo ThemeFunctions::getInlineSvg('whatsapp-banner'); ?>
                                    <span class="contact--desktop">
                                        <?php echo $whatsapp_text ?>
                                    </span>
                                                        <span class="contact--mobile">
                                        <?php echo $whatsapp_text_mobile ?>
                                    </span>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>

                </div>
            </div>

            <div class="header-middle">
                <div class="container">

                    <div class="burger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="site-branding">
                        <?php the_custom_logo(); ?>
                    </div>
                    <?php if ( function_exists( 'icl_get_languages' ) ): ?>
                        <div class="language-switcher">
                            <?php do_action( 'wpml_add_language_selector' ); ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    if (Kirki::get_option('header_site_name_enable') === true) {
                        ?>
                        <div class="site-name"><?php echo get_bloginfo('name'); ?></div>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <?php if ($show_mega_menu) { ?>
                <?php
                $header_menu = get_field('menu', 'option');
                ?>

                <?php if ($header_menu) { ?>
                    <div class="header-bottom header-bottom--desktop">
                    <div class="container">
                        <div class="wrapper">
                            <nav class="main-navigation">

                                <?php
                                $menu_html_desktop = '';
                                $dropdowns_html_desktop = '';

                                if (!empty($header_menu) && is_array($header_menu)):
                                    foreach ($header_menu as $index => $menu_item):
                                        $menu_link    = $menu_item['menu_item']['url'] ?? '#';
                                        $menu_label   = $menu_item['menu_item']['title'] ?? 'Menu Item';
                                        $submenu      = $menu_item['taxonomy_term'] ?? [];
                                        $show_submenu = $menu_item['show_submenu'];
                                        $content      = $menu_item['content'];

                                        // Уникальный ID для связывания <li> и <div class="dropdown">
                                        $menu_id = "menu-item-desktop-$index";

                                        // Собираем li
                                        $menu_html_desktop .= '<li class="menu-item';
                                        if ($show_submenu == 'Show') {
                                            $menu_html_desktop .= ' menu-item-has-children';
                                        }
                                        $menu_html_desktop .= '"';
                                        if ($show_submenu == 'Show') {
                                            $menu_html_desktop .= " data-menu-id='{$menu_id}'";
                                        }
                                        $menu_html_desktop .= '>';

                                        $menu_html_desktop .= '<a href="' . esc_url($menu_link) . '"><span>';
                                        $menu_html_desktop .= esc_html($menu_label);
                                        $menu_html_desktop .= '</span></a>';
                                        $menu_html_desktop .= '</li>';

                                        // Если нужно показать подменю, формируем HTML дропдауна
                                        if ($show_submenu == 'Show') {
                                            ob_start(); // Начинаем буферизацию, чтобы удобно собрать большой HTML

                                            ?>
                                            <div class="dropdown" data-parent-id="<?php echo $menu_id; ?>">
                                                <div class="dropdown__wrapper">
                                                    <div class="dropdown__container">
                                                        <?php if ($content == 'services') : ?>
                                                            <div class="dropdown__row dropdown__row--services">
                                                                <div class="dropdown__col list">
                                                                    <ul class="sub-menu">
                                                                        <?php foreach ($submenu as $sub_index => $term_id):
                                                                            $term = get_term($term_id);
                                                                            if (!$term || is_wp_error($term)) {
                                                                                continue;
                                                                            }
                                                                            $term_link = get_term_link($term);
                                                                            $submenu_id = "submenu-item-desktop-$index-$sub_index";
                                                                            ?>
                                                                            <li class="menu-item">
                                                                                <a href="<?php echo esc_url($term_link); ?>" data-submenu-id="<?php echo esc_attr($submenu_id); ?>">
                                                                                    <?php echo esc_html($term->name); ?>
                                                                                </a>
                                                                            </li>
                                                                        <?php endforeach; ?>
                                                                    </ul>
                                                                </div>
                                                                <div class="dropdown__col related">
                                                                    <?php foreach ($submenu as $sub_index => $sub_item):
                                                                        $submenu_id = "submenu-item-desktop-$index-$sub_index";

                                                                        // Получаем объект термина
                                                                        $term = get_term($sub_item, 'services');
                                                                        if (!$term || is_wp_error($term)) {
                                                                            continue;
                                                                        }

                                                                        $submenu_taxonomy_term = $term->slug;
                                                                        $related_posts = get_posts([
                                                                            'post_type'      => 'models',
                                                                            'posts_per_page' => 30,
                                                                            'orderby'        => 'rand',
                                                                            'tax_query'      => [
                                                                                [
                                                                                    'taxonomy' => 'services',
                                                                                    'field'    => 'slug',
                                                                                    'terms'    => $submenu_taxonomy_term,
                                                                                ]
                                                                            ]
                                                                        ]);
                                                                        ?>
                                                                        <div class="related__grid" data-submenu-id="<?php echo esc_attr($submenu_id); ?>">
                                                                            <?php if (!empty($related_posts)): ?>
                                                                                <?php foreach ($related_posts as $related_post): ?>
                                                                                    <?php
                                                                                    $gallery = get_field('model_photos', $related_post->ID);
                                                                                    $first_image = (!empty($gallery) && isset($gallery[0])) ? wp_get_attachment_image_url($gallery[0], 'medium') : '';
                                                                                    ?>
                                                                                    <div class="related__item">
                                                                                        <a href="<?php echo get_permalink($related_post->ID); ?>">
                                                                                            <?php if ($first_image): ?>
                                                                                                <img src="<?php echo esc_url($first_image); ?>" alt="<?php echo esc_attr(get_the_title($related_post->ID)); ?>">
                                                                                            <?php endif; ?>
                                                                                            <span><?php echo esc_html(get_the_title($related_post->ID)); ?></span>
                                                                                        </a>
                                                                                    </div>
                                                                                <?php endforeach; ?>
                                                                            <?php else: ?>
                                                                                <div class="related__item"> <?php echo esc_html__('Нет записей', 'pt-luna'); ?></div>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="dropdown__row dropdown__row--other">
                                                                <?php
                                                                $taxonomy = $menu_item['taxonomy'][0]->name ?? '';
                                                                $terms = get_terms([
                                                                    'taxonomy'   => $taxonomy,
                                                                    'orderby'    => 'name',
                                                                    'order'      => 'ASC',
                                                                    'hide_empty' => false,
                                                                ]);

                                                                // Собираем список первых букв
                                                                $letters = [];
                                                                if (!empty($terms) && !is_wp_error($terms)) {
                                                                    foreach ($terms as $term) {
                                                                        $first_letter = mb_strtoupper(mb_substr($term->name, 0, 1));
                                                                        $letters[$first_letter] = true;
                                                                    }
                                                                }
                                                                ?>
                                                                <div class="dropdown__col list">
                                                                    <div class="alphabet-filter">
                                                                        <button data-letter="all" class="alphabet-button active"><?php echo esc_html__('Все', 'pt-luna'); ?></button>
                                                                        <?php foreach (array_keys($letters) as $letter): ?>
                                                                            <button data-letter="<?php echo esc_attr($letter); ?>" class="alphabet-button">
                                                                                <?php echo esc_html($letter); ?>
                                                                            </button>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="dropdown__col related">
                                                                    <div class="related__grid">
                                                                        <?php
                                                                        if (!empty($terms) && !is_wp_error($terms)):
                                                                            foreach ($terms as $term):
                                                                                $term_image = get_term_meta($term->term_id, 'your_custom_image_field', true);
                                                                                $first_letter = mb_strtoupper(mb_substr($term->name, 0, 1));
                                                                                ?>
                                                                                <div class="related__item" data-letter="<?php echo esc_attr($first_letter); ?>">
                                                                                    <a href="<?php echo get_term_link($term); ?>">
                                                                                        <?php if ($term_image): ?>
                                                                                            <img src="<?php echo esc_url($term_image); ?>" alt="<?php echo esc_attr($term->name); ?>">
                                                                                        <?php endif; ?>
                                                                                        <span><?php echo esc_html($term->name); ?></span>
                                                                                    </a>
                                                                                </div>
                                                                            <?php endforeach; ?>
                                                                        <?php else: ?>
                                                                            <div class="related__item"> <?php echo esc_html__('Нет записей', 'pt-luna'); ?></div>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php

                                            // Забираем HTML из буфера
                                            $dropdowns_html_desktop .= ob_get_clean();
                                        }
                                    endforeach;
                                endif;
                                ?>

                                <!-- Выводим готовый список меню и затем блок с дропдаунами -->
                                <ul class="menu">
                                    <?php echo $menu_html_desktop; ?>
                                </ul>

                                <div class="dropdowns">
                                    <?php echo $dropdowns_html_desktop; ?>
                                </div>

                            </nav>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <!-- МОБИЛЬНАЯ ВЕРСИЯ МЕНЮ -->
                <?php if ($header_menu) { ?>
                    <div class="header-bottom header-bottom--mobile">
                    <div class="container">
                        <div class="wrapper">
                            <nav class="main-navigation">
                                <?php
                                // Аналогичная логика, но для мобильного меню (другие posts_per_page и т.д.)
                                $menu_html_mobile = '';
                                $dropdowns_html_mobile = '';

                                if (!empty($header_menu) && is_array($header_menu)):
                                    foreach ($header_menu as $index => $menu_item):
                                        $menu_link    = $menu_item['menu_item']['url'] ?? '#';
                                        $menu_label   = $menu_item['menu_item']['title'] ?? 'Menu Item';
                                        $submenu      = $menu_item['taxonomy_term'] ?? [];
                                        $show_submenu = $menu_item['show_submenu'];
                                        $content      = $menu_item['content'];

                                        // Уникальный ID для мобильной версии, чтобы избежать конфликтов
                                        $menu_id = "menu-item-mobile-$index";

                                        // Собираем li
                                        $menu_html_mobile .= '<li class="menu-item';
                                        if ($show_submenu == 'Show') {
                                            $menu_html_mobile .= ' menu-item-has-children';
                                        }
                                        $menu_html_mobile .= '"';
                                        if ($show_submenu == 'Show') {
                                            $menu_html_mobile .= " data-menu-id='{$menu_id}'";
                                        }
                                        $menu_html_mobile .= '>';

                                        $menu_html_mobile .= '<a href="' . esc_url($menu_link) . '">';
                                        $menu_html_mobile .= esc_html($menu_label);
                                        $menu_html_mobile .= '</a>';
                                        $menu_html_mobile .= '</li>';

                                        // Если показываем подменю - формируем дропдаун
                                        if ($show_submenu == 'Show') {
                                            ob_start();
                                            ?>
                                            <div class="dropdown" data-parent-id="<?php echo $menu_id; ?>">
                                                <div class="dropdown__wrapper">
                                                    <div class="dropdown__container">
                                                        <?php if ($content == 'services') : ?>
                                                            <div class="dropdown__row dropdown__row--services">
                                                                <div class="dropdown__col list">
                                                                    <ul class="sub-menu">
                                                                        <?php foreach ($submenu as $sub_index => $term_id):
                                                                            $term = get_term($term_id);
                                                                            if (!$term || is_wp_error($term)) {
                                                                                continue;
                                                                            }
                                                                            $term_link = get_term_link($term);
                                                                            $submenu_id = "submenu-item-mobile-$index-$sub_index";
                                                                            ?>
                                                                            <li class="menu-item">
                                                                                <a href="<?php echo esc_url($term_link); ?>" data-submenu-id="<?php echo esc_attr($submenu_id); ?>">
                                                                                    <?php echo esc_html($term->name); ?>
                                                                                </a>
                                                                            </li>
                                                                        <?php endforeach; ?>
                                                                    </ul>
                                                                </div>
                                                                <div class="dropdown__col related">
                                                                    <?php foreach ($submenu as $sub_index => $sub_item):
                                                                        $submenu_id = "submenu-item-mobile-$index-$sub_index";

                                                                        // Получаем объект термина
                                                                        $term = get_term($sub_item, 'services');
                                                                        if (!$term || is_wp_error($term)) {
                                                                            continue;
                                                                        }

                                                                        $submenu_taxonomy_term = $term->slug;
                                                                        $term_link = get_term_link($term);

                                                                        $related_posts = get_posts([
                                                                            'post_type'      => 'models',
                                                                            'posts_per_page' => 15, // для мобильной версии
                                                                            'orderby'        => 'rand',
                                                                            'tax_query'      => [
                                                                                [
                                                                                    'taxonomy' => 'services',
                                                                                    'field'    => 'slug',
                                                                                    'terms'    => $submenu_taxonomy_term,
                                                                                ]
                                                                            ]
                                                                        ]);
                                                                        ?>
                                                                        <div class="related__wrapper" data-submenu-id="<?php echo esc_attr($submenu_id); ?>">
                                                                            <div class="related__link">
                                                                                <?php if (!is_wp_error($term_link) && !empty($term_link)): ?>
                                                                                    <a href="<?php echo esc_url($term_link); ?>"><?php echo esc_html__('Посмотреть все', 'pt-luna'); ?></a>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                            <div class="related__grid">
                                                                                <?php if (!empty($related_posts)): ?>
                                                                                    <?php foreach ($related_posts as $related_post): ?>
                                                                                        <?php
                                                                                        $gallery = get_field('model_photos', $related_post->ID);
                                                                                        $first_image = (!empty($gallery) && isset($gallery[0]))
                                                                                            ? wp_get_attachment_image_url($gallery[0], 'medium')
                                                                                            : '';
                                                                                        ?>
                                                                                        <div class="related__item">
                                                                                            <a href="<?php echo get_permalink($related_post->ID); ?>">
                                                                                                <?php if ($first_image): ?>
                                                                                                    <img src="<?php echo esc_url($first_image); ?>" alt="<?php echo esc_attr(get_the_title($related_post->ID)); ?>">
                                                                                                <?php endif; ?>
                                                                                                <span><?php echo esc_html(get_the_title($related_post->ID)); ?></span>
                                                                                            </a>
                                                                                        </div>
                                                                                    <?php endforeach; ?>
                                                                                <?php else: ?>
                                                                                    <div class="related__item"> <?php echo esc_html__('Нет записей', 'pt-luna'); ?></div>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="dropdown__row dropdown__row--other">
                                                                <?php
                                                                $taxonomy = $menu_item['taxonomy'][0]->name ?? '';
                                                                $terms = get_terms([
                                                                    'taxonomy'   => $taxonomy,
                                                                    'orderby'    => 'name',
                                                                    'order'      => 'ASC',
                                                                    'hide_empty' => false,
                                                                ]);

                                                                // Список первых букв
                                                                $letters = [];
                                                                if (!empty($terms) && !is_wp_error($terms)) {
                                                                    foreach ($terms as $term) {
                                                                        $first_letter = mb_strtoupper(mb_substr($term->name, 0, 1));
                                                                        $letters[$first_letter] = true;
                                                                    }
                                                                }
                                                                ?>
                                                                <div class="dropdown__col list">
                                                                    <div class="alphabet-filter">
                                                                        <button data-letter="all" class="alphabet-button active"><?php echo esc_html__('Все', 'pt-luna'); ?></button>
                                                                        <?php foreach (array_keys($letters) as $letter): ?>
                                                                            <button data-letter="<?php echo esc_attr($letter); ?>" class="alphabet-button">
                                                                                <?php echo esc_html($letter); ?>
                                                                            </button>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="dropdown__col related">
                                                                    <div class="related__grid">
                                                                        <?php
                                                                        if (!empty($terms) && !is_wp_error($terms)):
                                                                            foreach ($terms as $term):
                                                                                $term_image = get_term_meta($term->term_id, 'your_custom_image_field', true);
                                                                                $first_letter = mb_strtoupper(mb_substr($term->name, 0, 1));
                                                                                ?>
                                                                                <div class="related__item" data-letter="<?php echo esc_attr($first_letter); ?>">
                                                                                    <a href="<?php echo get_term_link($term); ?>">
                                                                                        <?php if ($term_image): ?>
                                                                                            <img src="<?php echo esc_url($term_image); ?>" alt="<?php echo esc_attr($term->name); ?>">
                                                                                        <?php endif; ?>
                                                                                        <span><?php echo esc_html($term->name); ?></span>
                                                                                    </a>
                                                                                </div>
                                                                            <?php endforeach; ?>
                                                                        <?php else: ?>
                                                                            <div class="related__item"> <?php echo esc_html__('Нет записей', 'pt-luna'); ?></div>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php

                                            // Собираем буфер
                                            $dropdowns_html_mobile .= ob_get_clean();
                                        }
                                    endforeach;
                                endif;
                                ?>

                                <!-- Вывод меню и блок дропдаунов -->
                                <ul class="menu">
                                    <?php echo $menu_html_mobile; ?>
                                </ul>

                                <div class="dropdowns">
                                    <?php echo $dropdowns_html_mobile; ?>
                                </div>

                            </nav>
                        </div>
                    </div>
                </div>
                <?php } ?>

            <?php } else { ?>
                <div class="header-bottom header-bottom-default">
                    <div class="container">
                        <div class="wrapper">
                            <?php
                            wp_nav_menu([
                                'theme_location' => 'header_menu',
                                'menu_class'     => 'header-menu',
                                'container'      => false,
                                'walker'         => new DefaultMenuWalker(),
                            ]);
                            ?>

                        </div>
                    </div>
                </div>

                <div class="header-default--mobile">
                    <div class="container">
                        <div class="wrapper">
                            <?php
                            wp_nav_menu([
                                'theme_location' => 'header_menu',
                                'menu_class'     => 'header-menu',
                                'container'      => false,
                                'walker'         => new DefaultMenuWalker(),
                            ]);
                            ?>
                        </div>
                    </div>
                </div>

            <?php } ?>

        </div>
    </header>

    <?php
    get_template_part('template-parts/breadcrumbs');
    ?>
