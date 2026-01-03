<?php

use ESC\Luna\ThemeFunctions;
use ESC\Luna\MegaMenuWalker;
use ESC\Luna\DefaultMenuWalker;
use Kirki\Compatibility\Kirki;
use ESC\Luna\Modules\CitiesModule;

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

$header_class = 'header--default';
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

$switcher_city_enable = Kirki::get_option('switcher_enable');
$switcher_city_text = Kirki::get_option('switcher_text') ?? 'Город';

$cities = get_terms([
    'taxonomy'   => 'city',
    'hide_empty' => false,
]);

$current_city = CitiesModule::get_current_city_slug();

$location = 'header_menu';
if ($current_city) {
    $possible_location = 'header_menu_' . $current_city;
    if (has_nav_menu($possible_location)) {
        $location = $possible_location;
    }
}

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

                    <?php if ($switcher_city_enable) : ?>
                        <div class="city-switcher">
                        <div class="city-dropdown">
                            <div class="city-selected">
                                <span>
                                    <?php echo $current_city ? esc_html(get_term_by('slug', $current_city, 'city')->name) : $switcher_city_text; ?>
                                </span>
                                <?php echo ThemeFunctions::getInlineSvg('arrowdown')?>
                            </div>
                            <div class="city-options">
                                <?php foreach ($cities as $city): ?>
                                    <div class="city-option" data-value="<?php echo esc_attr($city->slug); ?>">
                                        <?php echo esc_html($city->name); ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
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

                <div class="header-bottom header-bottom-default">
                    <div class="container">
                        <div class="wrapper">
                            <?php
                            wp_nav_menu([
                                'theme_location' => $location,
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
                                'theme_location' => $location,
                                'menu_class'     => 'header-menu',
                                'container'      => false,
                                'walker'         => new DefaultMenuWalker(),
                            ]);
                            ?>

                            <?php if ($switcher_city_enable) : ?>
                                <div class="city-switcher">
                                    <div class="city-dropdown">
                                        <div class="city-selected">
                                <span>
                                    <?php echo $current_city ? esc_html(get_term_by('slug', $current_city, 'city')->name) : 'Выберите город'; ?>
                                </span>
                                            <?php echo ThemeFunctions::getInlineSvg('arrowdown')?>
                                        </div>
                                        <div class="city-options">
                                            <?php foreach ($cities as $city): ?>
                                                <div class="city-option" data-value="<?php echo esc_attr($city->slug); ?>">
                                                    <?php echo esc_html($city->name); ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>

        </div>
    </header>

    <?php
    get_template_part('template-parts/breadcrumbs');
    ?>
