<?php

use ESC\Luna\ThemeFunctions;
use Kirki\Compatibility\Kirki;

$uniq_id  = uniqid('contacts-block-', false);

$image    = get_field('image');
$image_side = get_field('image_side') == 'right' ? 'contacts-block--right' : 'contacts-block--left';

$hint_text = icl_t( 'Kirki', 'Hint Text', Kirki::get_option('contacts_hint') );

$phone = '';
if (Kirki::get_option('contacts_phone_enable')) {
    $phone = get_field('phone') ?: Kirki::get_option('contacts_phone');
}

$whatsapp = '';
if (Kirki::get_option('contacts_whatsapp_enable')) {
    $whatsapp = get_field('whatsapp') ?: Kirki::get_option('contacts_whatsapp');
}

$telegram = '';
if (Kirki::get_option('contacts_telegram_enable')) {
    $telegram = get_field('telegram') ?: Kirki::get_option('contacts_telegram');
}

if ($phone || $telegram || $whatsapp): ?>
    <section class="wrapper contacts-block <?php echo $image_side; ?>" id="<?php echo esc_attr($uniq_id); ?>">
        <div class="row">
            <?php if (!empty($image) && isset($image['url'])): ?>
                <div class="image">
                    <img
                            src="<?php echo esc_url($image['url']); ?>"
                            alt="<?php echo esc_attr($image['alt'] ?: $image['title'] ?: 'Contact image'); ?>"
                            loading="lazy"
                            width="<?php echo esc_attr($image['width']); ?>"
                            height="<?php echo esc_attr($image['height']); ?>"
                    >
                </div>
            <?php endif; ?>

            <div class="contacts">
                <?php if ($phone): ?>
                    <div class="phone">
                        <a id="single-pn" class="link phone-number" href="tel:<?php echo esc_attr($phone); ?>">
                            <?php echo esc_html($phone); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <?php if ($telegram || $whatsapp): ?>
                    <?php if ($hint_text) : ?>
                        <p class="text">
                            <?php echo $hint_text ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($telegram): ?>
                        <a class="link tg-number" href="<?php echo esc_url($telegram); ?>" target="_blank" rel="noopener noreferrer">
                            <?php echo ThemeFunctions::getInlineSvg('telegram'); ?>
                            <span><?php echo esc_html__('Telegram', 'pt-luna'); ?></span>
                        </a>
                    <?php endif; ?>

                    <?php if ($whatsapp): ?>
                        <a class="link wa-number" href="<?php echo esc_url($whatsapp); ?>" target="_blank" rel="noopener noreferrer">
                            <?php echo ThemeFunctions::getInlineSvg('whatsapp'); ?>
                            <span><?php echo esc_html__('Whatsapp', 'pt-luna'); ?></span>
                        </a>
                    <?php endif; ?>

                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
