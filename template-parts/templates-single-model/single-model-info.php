<?php
    use ESC\Luna\ThemeFunctions;

    $post_id = get_the_ID();

    $title = get_the_title();
    $model_price_1 = get_field('model_price_1');
    $model_price_2 = get_field('model_price_2');
    $model_price_night = get_field('model_price_night');
    $currency_symbol = get_field('site_currency', 'option') ? get_field('site_currency', 'option') :'₽';
    $model_age = get_field('model_age');
    $model_height = get_field('model_height');
    $model_weight = get_field('model_weight');
    $model_bust_size = get_field('model_bust_size');
    $model_hair_color = get_field('model_hair_color');

    $hair_color_translations = [
        'Блондинка' => [
            'en' => 'Blonde',
            'de' => 'Blondine',
        ],
        'Брюнетка' => [
            'en' => 'Brunette',
            'de' => 'Brünette',
        ],
        'Шатенка' => [
            'en' => 'Brown-haired',
            'de' => 'Braunhaarige',
        ],
        'Русая' => [
            'en' => 'Light brown',
            'de' => 'Hellbraun',
        ],
        'Рыжая' => [
            'en' => 'Redhead',
            'de' => 'Rothaarige',
        ],
    ];

    $current_lang = apply_filters( 'wpml_current_language', null ) ?? 'ru';

    $price_labels = [
        'ru' => [
            'hour'  => 'Цена за час',
            '2hour' => 'Цена за 2 часа',
            'night' => 'Цена за ночь',
        ],
        'en' => [
            'hour'  => 'Price per hour',
            '2hour' => 'Price for 2 hours',
            'night' => 'Price per night',
        ],
        'de' => [
            'hour'  => 'Preis pro Stunde',
            '2hour' => 'Preis für 2 Stunden',
            'night' => 'Preis pro Nacht',
        ],
        'ua' => [
            'hour'  => 'Ціна за годину',
            '2hour' => 'Ціна за 2 години',
            'night' => 'Ціна за ніч',
        ],
    ];

    $translated_hair_color = $hair_color_translations[$model_hair_color][$current_lang] ?? $model_hair_color;

    $area_terms = get_the_terms($post_id, 'area');
    $metro_terms = get_the_terms($post_id, 'metro');

    $area = !empty($area_terms) ? $area_terms[0] : null;
    $metro = !empty($metro_terms) ? $metro_terms[0] : null;

    $parameters = [
        esc_html__('Рост', 'pt-luna')         => $model_height . ' ' . esc_html__('см', 'pt-luna'),
        esc_html__('Возраст', 'pt-luna')      => $model_age,
        esc_html__('Вес', 'pt-luna')          => $model_weight . ' ' . esc_html__('кг', 'pt-luna'),
        esc_html__('Цвет волос', 'pt-luna')   => $translated_hair_color,
        esc_html__('Размер Груди', 'pt-luna') => $model_bust_size,
    ];

    $translations = [
        'area' => [
            'ru' => 'Район:',
            'en' => 'Area:',
            'de' => 'Bezirk:',
            'ua' => 'Район:',
        ],
        'metro' => [
            'ru' => 'Станция метро:',
            'en' => 'Metro station:',
            'de' => 'U-Bahn-Station:',
            'ua' => 'Станція метро:',
        ],
        'parameters' => [
            'ru' => 'Параметры',
            'en' => 'Parameters',
            'de' => 'Parameter',
            'ua' => 'Параметри',
        ],
        'location' => [
            'ru' => 'Локация',
            'en' => 'Location',
            'de' => 'Standort',
            'ua' => 'Локація',
        ],
        'categories' => [
            'ru' => 'Категории:',
            'en' => 'Categories:',
            'de' => 'Kategorien:',
            'ua' => 'Категорії:',
        ],
    ];


// Проверяем, использует ли модель свои контакты
    $custom_contacts = get_field('model_contacts');

    // Получаем настройки контактов Kirki (если включены)
    $kir_phone = Kirki::get_option('contacts_phone_enable') ? Kirki::get_option('contacts_phone') : '';
    $kir_telegram = Kirki::get_option('contacts_telegram_enable') ? Kirki::get_option('contacts_telegram') : '';
    $kir_whatsapp = Kirki::get_option('contacts_whatsapp_enable') ? Kirki::get_option('contacts_whatsapp') : '';
    $model_phone = $custom_contacts ? get_field('model_phone') : $kir_phone;
    $model_telegram = $custom_contacts ? get_field('model_telegram') : $kir_telegram;
    $model_whatsapp = $custom_contacts ? get_field('model_whatsapp') : $kir_whatsapp;

    $hint_text = icl_t( 'Kirki', 'Hint Text', Kirki::get_option('contacts_hint') );


    $show_prices = Kirki::get_option('single_model_show_prices');

    $options = get_the_terms($post_id, 'options');

?>

<div class="info">
    <div class="top">
        <div class="info-card info-card--params">
            <div class="header">
                <div class="title">

                    <?php
                    if (! empty($title)) { ?>
                        <h1 class="h3">
                            <?php echo $title; ?>
                        </h1>
                    <?php }
                    ?>

                </div>
            </div>

            <?php
            if (!empty($model_price_1) || !empty($model_price_2) || !empty($model_price_night)) {
                ?>
                <div class="prices">
                    <?php if (!empty($model_price_1)) { ?>
                        <div class="price">
                            <?php echo esc_html($price_labels[$current_lang]['hour']); ?>
                            <div class="num"><?php echo $model_price_1 . $currency_symbol ?></div>
                        </div>
                        <?php
                        $prices = [
                            ["title" => $price_labels[$current_lang]['hour'],  "price" => $model_price_1],
                            ["title" => $price_labels[$current_lang]['2hour'], "price" => $model_price_2],
                            ["title" => $price_labels[$current_lang]['night'], "price" => $model_price_night],
                        ];

                        ?>
                        <?php if ($show_prices == 'show') { ?>
                            <div class="options">
                                <div class="options__wrapper">
                                    <div class="options__selected">
                                <span>
                                    <?php echo esc_html($prices[0]['title']); ?>
                                </span>
                                        <?php echo ThemeFunctions::getInlineSvg('arrowdown')?>
                                    </div>
                                    <div class="options__list">
                                        <?php foreach ($prices as $option): ?>
                                            <div class="options__item" data-price="<?php echo esc_attr($option['price']); ?>" data-value="<?php echo esc_attr($option['title']); ?>">
                                                <?php echo esc_html($option['title']); ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                        </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>

            <div class="info-tabs">
                <div class="wrapper">
                    <div class="item active" data-tab="params"><?php echo esc_html($translations['parameters'][$current_lang]); ?></div>
                    <div class="item" data-tab="location"><?php echo esc_html($translations['location'][$current_lang]); ?></div>
                </div>
                <?php if (!empty($parameters)) { ?>
                    <div class="tab-content params active">
                        <div class="block-table parameters">
                            <?php foreach ($parameters as $title => $value) { ?>
                                <div class="block-row">
                                    <div class="block-cell title"><?php echo esc_html__($title, 'pt-luna'); ?>:</div>
                                    <div class="block-cell value"><?php echo esc_html($value); ?></div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($area || $metro) { ?>
                    <div class="tab-content location">
                        <div class="block-table">
                            <?php if ($area) { ?>
                                <div class="block-row">
                                    <div class="block-cell title"><?php echo esc_html($translations['area'][$current_lang]); ?></div>
                                    <div class="block-cell value">
                                        <a class="link" href="<?php echo esc_url(get_tag_link($area)); ?>">
                                            <?php echo esc_html($area->name); ?>
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($metro) { ?>
                                <div class="block-row">
                                    <div class="block-cell title"><?php echo esc_html($translations['metro'][$current_lang]); ?></div>
                                    <div class="block-cell value">
                                        <a class="link" href="<?php echo esc_url(get_tag_link($metro)); ?>">
                                            <?php echo esc_html($metro->name); ?>
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>

                    </div>
                <?php } ?>

            </div>

            <?php

            if (!empty($model_phone) || !empty($model_telegram) || !empty($model_whatsapp)) { ?>
            <div class="contacts">
                <?php if (!empty($model_phone)) { ?>
                    <div class="phone">
                        <a id="single-pn" class="link phone-number" href="tel:<?php echo esc_attr($model_phone); ?>">
                            <?php echo esc_html($model_phone); ?>
                        </a>
                    </div>
                <?php } ?>

                <?php if (!empty($model_telegram) || !empty($model_whatsapp)) { ?>
                    <?php if ($hint_text) { ?>
                        <p class="text">
                            <?php echo $hint_text ?>
                        </p>
                    <?php } ?>

                    <?php if (!empty($model_telegram)) {
                        $tg_url = preg_match('~^https?://~', $model_telegram) ? $model_telegram : 'https://t.me/' . ltrim($model_telegram, '@');
                        ?>
                        <a class="link tg-number" href="<?php echo esc_url($tg_url); ?>" target="_blank" rel="noopener noreferrer">
                            <?php echo ThemeFunctions::getInlineSvg('telegram'); ?>
                            <span><?php echo esc_html__('Telegram', 'pt-luna') ?></span>
                        </a>
                    <?php } ?>

                    <?php if (!empty($model_whatsapp)) {
                        $wa_number = preg_replace('/\D+/', '', $model_whatsapp);
                        $wa_url = preg_match('~^https?://~', $model_whatsapp) ? $model_whatsapp : 'https://wa.me/' . $wa_number;
                        ?>
                        <a class="link wa-number" href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener noreferrer">
                            <?php echo ThemeFunctions::getInlineSvg('whatsapp'); ?>
                            <span><?php echo esc_html__('Whatsapp', 'pt-luna') ?></span>
                        </a>
                    <?php } ?>
                <?php } ?>
            </div>
            <?php }

            if (!empty($options) && !is_wp_error($options)) {
                ?>
                <div class="tags">
                    <div class="label">
                        <?php echo esc_html($translations['categories'][$current_lang]); ?>
                    </div>
                    <div class="list">
                        <?php
                        $tags = array_map(function ($option) {
                            return '<a href="' . esc_url(get_term_link($option)) . '" class="tag-link">' . esc_html($option->name) . '</a>';
                        }, $options);

                        echo wp_kses_post(implode(', ', $tags));
                        ?>
                    </div>
                </div>
                <?php
            }

            ?>
        </div>
    </div>
</div>

