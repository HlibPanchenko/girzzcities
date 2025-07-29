<?php

$uniq_id = uniqid('cg-');

$title = get_field('title');
$image = get_field('image');
$image_side = get_field('image_side');
$icon = get_field('icon');
$color = get_field('color');
$background_color = get_field('background_color');

$cities = get_terms([
    'taxonomy'   => 'city',
    'hide_empty' => false,
]);
?>

<section class="city-grid <?php echo $image_side === 'right' ? 'image-right' : 'image-left'; ?>" id="<?php echo $uniq_id; ?>">
    <div class="container">
        <div class="wrapper">
            <div class="col col--content">
                <div class="content">

                    <?php if ($title): ?>
                        <h2 class="section-title h5"><?php echo esc_html($title); ?></h2>
                    <?php endif; ?>

                    <?php if (!empty($cities) && !is_wp_error($cities)): ?>
                        <ul class="city-list">
                            <?php foreach ($cities as $city): ?>
                                <li class="city-item">
                                    <a href="<?php echo esc_url(home_url('/' . $city->slug . '/')); ?>">
                                        <span class="city-name"><?php echo esc_html($city->name); ?></span>
                                        <?php if ($icon): ?>
                                            <span class="city-icon">
                                                <img src="<?php echo esc_url($icon['url']); ?>"
                                                     alt=""
                                                     class="icon">
                                            </span>
                                        <?php endif; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>Города пока не добавлены.</p>
                    <?php endif; ?>

                </div>
            </div>
            <div class="col col--image">
                <?php if ($image): ?>
                    <div class="image">
                        <div class="image-wrapper">
                            <img class="no-lazy image_desktop"
                                 src="<?php echo esc_url($image['url']); ?>"
                                 alt="<?php echo esc_attr($title ?: 'City grid image'); ?>">
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<style>
    <?php
    echo <<<EOT
         #$uniq_id .content {
             background-color: $background_color;
         }
         
         #$uniq_id h2 {
              color: $color;
         }
         
          #$uniq_id a {
              color: $color;
         }
         
         #$uniq_id .city-list li {
              border: 1px solid $color;
         }
         
         #$uniq_id .city-list li:hover {
              background-color: $color;
         }
         
         #$uniq_id .city-list li:hover a{
               color: $background_color;
         }
         
        
    EOT;
    ?>
</style>
