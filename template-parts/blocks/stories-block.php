<?php
use ESC\Luna\ThemeFunctions;
$uniq_id = uniqid('stories-', false);

$stories = get_field('stories');
$title = get_field('stories_title');
$mode = get_field('stories_mode');
$stories_amount = get_field('number_of_stories');
$stories_style = get_field('stories_style_block') ?? 'style_1';

function displayStories ($id, $title, $link, $date, $profile_image, $preview, $video, $style): void
    {
        ?>
        <div class="story" data-id="<?php echo $id ?>" data-last-updated="<?php echo $date ?>" data-photo="<?php echo $profile_image ?>">
            <a class="item-link" href="<?php echo $link ?>">
                <span class="item-preview">
                   <img
                       class="no-lazy"
                       src="<?php echo esc_url(!empty($preview) ? (($style !== 'style_1') ? $preview : $profile_image) : $profile_image); ?>"
                       alt="<?php echo esc_attr($title); ?>"
                   />
                </span>
                <span class="info" itemprop="author">
                    <strong class="name" itemprop="name"><?php echo $title ?></strong>
                    <span class="time"></span>
                </span>

                <?php
                if ($style !== 'style_1') {
                    ?>
                    <img class="no-lazy profile" src="<?php echo $profile_image ?>" alt="<?php echo $title ?>"/>
                    <?php
                }
                ?>
            </a>
            <ul class="items">
                <li data-id="<?php echo $id ?>" data-time="<?php echo $date ?>">
                    <a href="<?php echo $video ?>" data-type="video" data-link="<?php echo $link ?>" data-linkText="<?php echo $title ?>">
                        <img class="no-lazy" src="<?php echo $profile_image ?>" alt="<?php echo $title ?>"/>
                    </a>
                </li>
            </ul>
        </div>
        <?php
    }
?>

<div id="<?php echo $uniq_id; ?>" class="stories-block stories-wrapper <?php echo $stories_style; ?>">
    <?php
    if (!empty($title)) {
        ?>
        <h2 class="h3 stories-title"><?php echo $title; ?></h2>
        <?php
    }
    ?>

    <div class="stories-wrapper">
        <div id="stories">
        <?php
        if (!empty($mode) && $mode === true) {
            ?>
                <?php
                if (! empty($stories)) {
                    foreach ($stories as $story) {
                        $story_id = $story['preview']['ID'];
                        $story_title = esc_html($story['title']);
                        $story_link = esc_url($story['model-link']);
                        $story_date = strtotime($story['preview']['date']);
                        $story_preview = esc_url($story['preview']['url']);
                        $story_media = esc_url($story['media']);

                        displayStories($story_id, $story_title, $story_link, $story_date, $story_preview, $story_preview, $story_media, $stories_style);
                    }
                }
                ?>
            <?php
        } else {
            ?>
            <?php
            $args = [
                'post_type' => 'models',
                'posts_per_page' => $stories_amount,
                'orderby' => 'rand',
                'meta_query' => [
                    [
                        'key' => 'model_has_video',
                        'value' => '1',
                        'compare' => '='
                    ],
                ],
            ];

            $query = new WP_Query($args);
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();

                    $story_id = get_the_ID();
                    $story_title = get_the_title();
                    $story_date = get_the_date('U');
                    $story_link = get_permalink();

                    $model_photos = get_post_meta($story_id, 'model_photos', true);

                    if ($model_photos && is_array($model_photos)) {
                        $preview_url = '';
                        $video_url = '';

                        foreach ($model_photos as $media_id) {
                            $mime_type = get_post_mime_type($media_id);
                            $media_url = wp_get_attachment_url($media_id);

                            if (str_starts_with($mime_type, 'image/') && !$preview_url) {
                                $profile_image_url = $media_url;
                            }

                            if (str_starts_with($mime_type, 'video/') && !$video_url) {
                                $video_url = $media_url;
                            }

                            if ($preview_url && $video_url) {
                                break;
                            }
                        }
                    }

                    if ($stories_style !== 'style_1') {
                        $preview_url = ThemeFunctions::generateVideoPreviewFromUrl($video_url);
                    }

                    displayStories($story_id, $story_title, $story_link, $story_date, $profile_image_url, $preview_url, $video_url, $stories_style);
                }
                wp_reset_postdata();
            }
        }
        ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const options = {
            avatars: true,
            openEffect: true,
            cubeEffect: true,
            autoFullScreen: false,
            backButton: true,
            backNative: true,
            previousTap: true,
            localStorage: true,
            reactive: false,
            rtl: false,
            language: {
                visitLink: "Посмотреть анкету",
            },
        }

        const element = document.querySelector("#stories");
        const stories = Zuck(element, options);
    });
</script>
