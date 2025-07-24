<?php
$post_id = get_the_ID();
$model_photos = get_field('model_photos');
$unique_slider_id = 'slider-' . $post_id;

if ($model_photos) { ?>
    <div class="gallery">

        <div class="swiper | swiper-secondary model-secondary-swiper--js">
            <div class="swiper-wrapper">
                <?php foreach ($model_photos as $photo_id) {
                    $mime_type = get_post_mime_type($photo_id);
                    if (str_starts_with($mime_type, 'image/')) {
                        $img_url = wp_get_attachment_image_url($photo_id, 'thumbnail');
                        $alt_text = get_post_meta($photo_id, '_wp_attachment_image_alt', true);
                        ?>
                        <div class="swiper-slide">
                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($alt_text); ?>">
                        </div>
                    <?php } } ?>
            </div>
        </div>

        <div class="swiper | swiper-main model-swiper--js" id="<?php echo esc_attr($unique_slider_id); ?>">
            <div class="swiper-wrapper">
                <?php foreach ($model_photos as $photo_id) {
                    $mime_type = get_post_mime_type($photo_id);
                    if (str_starts_with($mime_type, 'image/')) {
                        $img_url = wp_get_attachment_image_url($photo_id, 'full');
                        $alt_text = get_post_meta($photo_id, '_wp_attachment_image_alt', true);
                        ?>
                        <div class="swiper-slide">
                            <a href="<?php echo esc_url($img_url); ?>" data-fancybox="gallery" data-caption="<?php echo esc_attr($alt_text); ?>">
                                <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($alt_text); ?>">
                            </a>
                        </div>
                    <?php } } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

    </div>
<?php } ?>
