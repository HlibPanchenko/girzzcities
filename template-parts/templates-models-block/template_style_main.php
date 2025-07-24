<?php

use ESC\Luna\ThemeFunctions;
use Kirki\Compatibility\Kirki;

$model_card_is_opened = Kirki::get_option('model_card_is_opened') == 'opened' ? 'card-new--opened' : 'card-new--closed';


$post_id = get_the_ID();
$model_price = get_field('model_price_1', $post_id) ?: get_field('model_price_2', $post_id) ?: get_field('model_price_3', $post_id);
$model_price_night = get_field('model_price_night', $post_id);

$model_name = get_the_title();
$short_model_name = (mb_strlen($model_name) > 20) ? mb_substr($model_name, 0, 20) . '...' : $model_name;
$model_age = get_field('model_age', $post_id);
$model_bust_size = get_field('model_bust_size', $post_id);
$model_height = get_field('model_height', $post_id);
$model_weight = get_field('model_weight', $post_id);

$model_link = get_permalink($post_id);
$model_photos = get_field('model_photos', $post_id);
$unique_slider_id = 'slider-' . $post_id;

if (get_the_terms($post_id, 'metro')) {
    $metro = get_the_terms($post_id, 'metro')[0];
}

$verified = get_field('model_verified', $post_id);
$has_video = get_field('model_has_video', $post_id);
$currency_symbol = get_field('site_currency', 'option') ? get_field('site_currency', 'option') :'₽';

$background_image_url = '';
$background_image_alt = '';

if ($model_photos && is_array($model_photos)) {
    $first_photo = $model_photos[0];

    $image_id = is_array($first_photo) ? $first_photo['ID'] : $first_photo;

    $background_image_url = wp_get_attachment_url($image_id);
    $background_image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
}

$current_lang = apply_filters( 'wpml_current_language', null ) ?? 'ru';

$translations = [
    'verified'     => [
        'ru' => 'Проверенная',
        'en' => 'Verified',
        'de' => 'Verifiziert',
        'uk' => 'Перевірена',
    ],
    'age'          => [
        'ru' => 'Возраст: ',
        'en' => 'Age: ',
        'de' => 'Alter: ',
        'uk' => 'Вік: ',
    ],
    'price_per_hr' => [
        'ru' => '/час',
        'en' => '/hour',
        'de' => '/Stunde',
        'uk' => '/год',
    ]
];

?>
<a href="<?php echo esc_url($model_link); ?>" class="card-new <?php echo $model_card_is_opened ?>">
    <div class="card-image">
        <img src="<?php echo esc_url($background_image_url); ?>" alt="<?php echo esc_attr($background_image_alt); ?>">
        <?php if ($verified) { ?>
            <div class="verified">
                <span><?php echo esc_html($translations['verified'][$current_lang]); ?></span>
            </div>
        <?php } ?>
    </div>
    <div class="card-info">
        <span class="card-name">
            <?php echo esc_html($short_model_name); ?>
        </span>
        <div class="card-body">
            <div class="card-params">
                <div class="param-item">
                    <span class="start"><?php echo esc_html($translations['age'][$current_lang]); ?></span>
                    <span class="end"><?php echo esc_html($model_age); ?></span>
                </div>
            </div>
            <?php if ($model_price) { ?>
                <div class="card-price">
                    <?php echo esc_html($model_price . $currency_symbol . $translations['price_per_hr'][$current_lang]); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</a>


