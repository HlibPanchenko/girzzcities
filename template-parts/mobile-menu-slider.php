<?php

use ESC\Luna\ThemeFunctions;
use Kirki\Compatibility\Kirki;

$phone_enable = Kirki::get_option('contacts_phone_enable');
$telegram_enable = Kirki::get_option('contacts_telegram_enable');
$whatsapp_enable = Kirki::get_option('contacts_whatsapp_enable');
$phone = Kirki::get_option('contacts_phone');
$telegram = Kirki::get_option('contacts_telegram');
$whatsapp = Kirki::get_option('contacts_whatsapp');
?>

<div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>

<div class="mobile-menu-slider" id="mobileMenu">
    <div class="menu-content">
        <div class="block">
            <h3 class="title"><?php _e('Связь с нами', 'pt-luna'); ?></h3>
            <div class="contacts">
                <?php if ($phone_enable || $telegram_enable || $whatsapp_enable): ?>
                    <div class="contacts-holder">
                        <?php if ($phone_enable === true): ?>
                            <a href="tel:<?php echo $phone ?>" id="phone-header" class="phone-number">
                                <?php echo ThemeFunctions::getInlineSvg('phone'); ?>
                            </a>
                        <?php endif; ?>
                        <div class="messengers-holder">
                            <?php if ($telegram_enable): ?>
                                <a href="<?php echo $telegram ?>" class="social-link social-link--telegram">
                                    <?php echo ThemeFunctions::getInlineSvg('telegram'); ?>
                                </a>
                            <?php endif; ?>
                            <?php if ($whatsapp_enable): ?>
                                <a href="<?php echo $whatsapp ?>" class="social-link social-link--whatsapp">
                                    <?php echo ThemeFunctions::getInlineSvg('whatsapp'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="block">
<!--            <h3 class="title">--><?php //_e('Наши услуги', 'pt-luna'); ?><!--</h3>-->
            <nav class="menu-nav">
                <?php
                wp_nav_menu([
                    'theme_location'  => 'header_burger_menu',
                    'menu_class'      => 'burger-nav-wrapper',
                    'container'       => false,
                    'depth'           => 2,
                ]);
                ?>
            </nav>

        </div>

    </div>
</div>
