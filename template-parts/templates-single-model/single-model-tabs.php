<?php
use ESC\Luna\ThemeFunctions;

$model_photos = get_field('model_photos');

$current_lang = apply_filters( 'wpml_current_language', null );

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

        <div class="content-tab services">
            <div class="block-items">
                <?php
                $taxonomy = 'services';
                $show_parent_terms = Kirki::get_option('single_model_services_parent_terms');

                if ($show_parent_terms) {
                    $terms = get_terms([
                        'taxonomy' => $taxonomy,
                        'orderby' => 'name',
                        'order' => 'DESC',
                        'parent' => 0,
                        'hide_empty' => false,
                    ]);

                    if (!empty($terms) && !is_wp_error($terms)) :
                        if (!function_exists('compare_term_children_count')) {
                            function compare_term_children_count($a, $b)
                            {
                                $a_children = get_term_children($a->term_id, $a->taxonomy);
                                $b_children = get_term_children($b->term_id, $b->taxonomy);
                                return count($b_children) - count($a_children);
                            }
                        }

                        usort($terms, 'compare_term_children_count');

                        foreach ($terms as $term) :
                            $children = get_terms([
                                'taxonomy' => $taxonomy,
                                'parent' => $term->term_id,
                                'hide_empty' => false,
                            ]);
                            if (empty($children)) {
                                continue;
                            }
                            ?>
                            <div class="block-item">
                                <div class="parent-title"><?php echo esc_html($term->name); ?></div>
                                <ul class="model-list">
                                    <?php foreach ($children as $child_term): ?>
                                        <li class="tag">
                                            <a href="<?php echo esc_url(get_term_link($child_term)); ?>" class="term-link">
                                                <?php echo esc_html($child_term->name); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php
                        endforeach;
                    endif;
                } else {
                    $all_terms = get_terms([
                        'taxonomy' => $taxonomy,
                        'orderby' => 'name',
                        'order' => 'ASC',
                        'hide_empty' => false,
                    ]);

                    if (!empty($all_terms) && !is_wp_error($all_terms)) :
                        $total_terms = count($all_terms);
                        $columns = 4;
                        $terms_per_column = ceil($total_terms / $columns);
                        $columns_data = array_chunk($all_terms, $terms_per_column);

                        foreach ($columns_data as $column): ?>
                            <div class="column">
                                <ul class="model-list">
                                    <?php foreach ($column as $term): ?>
                                        <li class="tag">
                                            <a href="<?php echo esc_url(get_term_link($term)); ?>" class="term-link">
                                                <?php echo esc_html($term->name); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endforeach;
                    endif;
                }
                ?>
            </div>
        </div>

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
