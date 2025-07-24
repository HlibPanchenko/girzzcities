<?php
use \ESC\Luna\ThemeFunctions;

$title = get_field('title');
$description = get_field('description');
$button = get_field('button');
$image = get_field('image');
$image_side = get_field('image_side') == 'left' ? 'wrapper--left' : 'wrapper--right';
?>

<section class="hero">
    <div class="wrapper <?php echo $image_side ?>">
            <div class="content">
                <?php if ($title): ?>
                    <?php echo $title; ?>
                <?php endif; ?>

                <?php if ($description): ?>
                    <p class="description"><?php echo $description ?></p>
                <?php endif; ?>

                <?php if ($button): ?>
                    <a href="tel:<?php echo esc_attr($button); ?>" class="button">+<?php echo esc_html($button); ?></a>
                <?php endif; ?>
            </div>
            <?php if ($image): ?>
                <div class="image">
                    <div class="image-wrapper">
                        <img class="no-lazy image_desktop" src="<?php echo esc_url($image['url']); ?>" alt="Модель">
                    </div>
                </div>
            <?php endif; ?>
        </div>
</section>
