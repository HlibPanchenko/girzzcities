<?php
use ESC\Luna\ThemeFunctions;
use ESC\Luna\Modules\CitiesModule;

$current_city_slug = CitiesModule::get_current_city_slug();

$model_photos = get_field('model_photos');

$current_lang = apply_filters( 'wpml_current_language', null )  ?? 'ru';

$translations = [
    'tabs' => [
        'services'    => [
            'ru' => 'Услуги',
            'en' => 'Services',
            'de' => 'Dienstleistungen',
            'ua' => 'Послуги',
        ],
        'description' => [
            'ru' => 'Описание',
            'en' => 'Description',
            'de' => 'Beschreibung',
            'ua' => 'Опис',
        ],
        'video'       => [
            'ru' => 'Видео',
            'en' => 'Video',
            'de' => 'Video',
            'ua' => 'Відео',
        ],
        'reviews'     => [
            'ru' => 'Отзывы',
            'en' => 'Reviews',
            'de' => 'Bewertungen',
            'ua' => 'Відгуки',
        ],
    ],
    'messages' => [
        'no_description' => [
            'ru' => 'У этой модели нет описания',
            'en' => 'This model has no description',
            'de' => 'Dieses Model hat keine Beschreibung',
            'ua' => 'У цієї моделі немає опису',
        ],
        'no_reviews' => [
            'ru' => 'Отзывов пока нет',
            'en' => 'No reviews yet',
            'de' => 'Noch keine Bewertungen',
            'ua' => 'Поки що немає відгуків',
        ],
        'no_video' => [
            'ru' => 'Видео пока нет',
            'en' => 'No video yet',
            'de' => 'Noch kein Video',
            'ua' => 'Відео ще немає',
        ],
        'video_fallback' => [
            'ru' => 'Ваш браузер не поддерживает воспроизведение видео.',
            'en' => 'Your browser does not support video playback.',
            'de' => 'Ihr Browser unterstützt keine Videowiedergabe.',
            'ua' => 'Ваш браузер не підтримує відтворення відео.',
        ]
    ]
];

?>
<div class="content">
    <div class="wrapper">
        <div class="tabs">
            <div class="item h6" data-tab="services"><?php echo esc_html($translations['tabs']['services'][$current_lang]); ?></div>
            <div class="item h6" data-tab="description"><?php echo esc_html($translations['tabs']['description'][$current_lang]); ?></div>
            <div class="item h6" data-tab="video"><?php echo esc_html($translations['tabs']['video'][$current_lang]); ?></div>
            <div class="item h6" data-tab="reviews"><?php echo esc_html($translations['tabs']['reviews'][$current_lang]); ?></div>

        </div>

        <?php
            $taxonomy = 'services';

            if ($current_city_slug) {
            $city_term = get_term_by('slug', $current_city_slug, $taxonomy);

            if ($city_term && !is_wp_error($city_term)) {
                $child_ids = get_term_children($city_term->term_id, $taxonomy);

                if (!empty($child_ids) && !is_wp_error($child_ids)) {
                    $services_terms = get_terms([
                        'taxonomy'   => $taxonomy,
                        'include'    => $child_ids,
                        'orderby'    => 'name',
                        'order'      => 'ASC',
                        'hide_empty' => false,
                    ]);

                    if (!empty($services_terms)): ?>
                        <div class="content-tab services">
                            <div class="block-items">
                                <div class="column">
                                    <ul class="model-list">
                                        <?php foreach ($services_terms as $term): ?>
                                            <li class="tag">
                                                <a href="<?php echo esc_url(get_term_link($term)); ?>" class="term-link">
                                                    <?php echo esc_html($term->name); ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif;
                }
            }
        }
        ?>


        <div class="content-tab description pt-content">
            <?php
            $description = get_field('model_about');
            if (!empty($description)) {
                echo $description;
            } else { ?>
                <p class="message"><?php echo esc_html($translations['messages']['no_description'][$current_lang]); ?></p>
                <?php
            }
            ?>
        </div>

        <?php

        $testimonials = get_field('model_testimonials');
        ?>

        <div class="content-tab reviews">
            <?php if (!empty($testimonials) && is_array($testimonials)) { ?>
                <ul>
                    <?php foreach ($testimonials as $index => $item): ?>
                        <?php
                        $name = $item['name'] ?: 'Client';
                        $encodedName = urlencode($name);
                        $avatarUrl = "https://ui-avatars.com/api/?name={$encodedName}&background=random&size=64";
                        ?>
                        <li>
                            <div class="left">
                                <div class="avatar">
                                    <img src="<?php echo $avatarUrl; ?>" alt="<?php echo htmlspecialchars($name); ?>">
                                </div>
                            </div>
                            <div class="right">
                                <span class="name h5">
                                    <?php echo $name; ?>
                                </span>
                                <div class="list-text">
                                    <?php echo $item['text']; ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php } else { ?>
                <p class="message"><?php echo esc_html($translations['messages']['no_reviews'][$current_lang]); ?></p>
            <?php } ?>
        </div>


        <div class="content-tab video">
            <?php
            if ($model_photos && is_array($model_photos)) {

                $is_video = false;

                foreach ($model_photos as $media_id){
                    $mime_type = get_post_mime_type($media_id);
                    $media_url = wp_get_attachment_url($media_id);


                    if (str_starts_with($mime_type, 'video/') && $media_url) { ?>
                        <div class="video-wrapper">
                            <video controls>
                                <source src="<?php echo esc_url($media_url); ?>" type="<?php echo esc_attr($mime_type); ?>">
                                <?php echo esc_html($translations['messages']['video_fallback'][$current_lang]); ?>
                            </video>
                        </div>
                        <?php
                        $is_video = true;
                        break;
                    }


                }

                if (!$is_video) { ?>
                    <p class="message"><?php echo esc_html($translations['messages']['no_video'][$current_lang]); ?></p>
                <?php }
            }
            ?>
        </div>

    </div>
</div>
