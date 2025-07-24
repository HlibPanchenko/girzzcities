<?php

use \ESC\Luna\ThemeFunctions;

$card_text = get_field('card_text');
$card_image = get_field('card_image');

$title = $card_text['title'] ?? '';
$description = $card_text['description'] ?? '';

$image = $card_image['image'] ?? null;
$image_description = $card_image['description'] ?? '';
$background = get_field('background');
$color = get_field('color');
$accent_color = get_field('accent_color');
?>

<style>
    .two-cards {
        --cards-background-color: <?php echo esc_attr($background); ?>;
        --cards-text-color: <?php echo esc_attr($color); ?>;
        --cards-accent-color: <?php echo esc_attr($accent_color); ?>;
    }
</style>

<section class="two-cards">
    <div class="wrapper">
        <div class="card card--text">
            <div class="card-text">
                <?php if ($title): ?>
                    <h3><?php echo esc_html($title); ?></h3>
                <?php endif; ?>

                <?php if ($description): ?>
                    <p><?php echo esc_html($description); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card card--img">
            <?php if ($image_description): ?>
                <p><?php echo $image_description; ?></p>
            <?php endif; ?>
            <?php if ($image): ?>
                <div class="card-image">
                    <img <?php ThemeFunctions::acfImageAttrs($image) ?> />
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
