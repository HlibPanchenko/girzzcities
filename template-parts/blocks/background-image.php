<?php

$uniq_id = uniqid('bg-block-', false);

$subtitle_color = get_field('subtitle_color');
$title_color = get_field('title_color');
$text_color = get_field('text_color');
$button_color = get_field('button_color');
$button_bg = get_field('button_bg');
$button_hover_bg = get_field('button_hover_bg');
?>

<section id="<?php echo $uniq_id; ?>" class="wrapper background-image-block-wrapper">
    <div class="background-image-content container">
        <?php echo wp_get_attachment_image(get_field('background_image'), 'large') ?>
        <span class="subtitle"><?php echo get_field('subtitle')?></span>
        <h2 class="title"><?php echo get_field('title')?></h2>
        <p class="description"><?php echo get_field('description')?></p>
        <?php if (get_field('button')) {
            ?>
            <a href="<?php echo get_field('button')['url']; ?>" class="button">
                <?php echo get_field('button')['title']; ?>
            </a>
            <?php
        }
        ?>
    </div>
</section>

<style>
    <?php
    echo <<<EOT
         #$uniq_id .background-image-content .title {
            color: $title_color;
         }
         #$uniq_id .subtitle {
            color: $subtitle_color;
         }
         #$uniq_id .description {
            color: $text_color;
         }
         #$uniq_id .button {
            color: $button_color;
            background-color: $button_bg;
         }
        
         @media (hover: hover) {
            #$uniq_id .button:hover {
            background-color: $button_hover_bg;
         }
         }
    EOT;
    ?>
</style>