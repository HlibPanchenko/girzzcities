<?php
use ESC\Luna\ThemeFunctions;

if (!isset($post) || !$post instanceof WP_Post) {
    return;
}

$verified = get_field('model_verified');

?>

<div class="related-post">
    <a href="<?php the_permalink($post->ID); ?>" class="related-post-link">
        <?php
        $model_photos = get_field('model_photos', $post->ID);

        if (!empty($model_photos) && is_array($model_photos)) {
            $image_url = esc_url(wp_get_attachment_image_url($model_photos[0], 'full'));
            $alt_text = esc_attr(get_post_meta($model_photos[0], '_wp_attachment_image_alt', true));
            echo '<div class="related-post-thumbnail">';
            echo '<img src="' . $image_url . '" alt="' . $alt_text . '">';
            echo '</div>';
        } elseif (has_post_thumbnail($post->ID)) {
            echo '<div class="related-post-thumbnail">';
            echo get_the_post_thumbnail($post->ID, 'thumbnail');
            echo '</div>';
        }
        ?>
        <div class="related-post-cred">
            <h4><?php echo get_the_title($post->ID); ?></h4>
            <?php if ($verified): ?>
                <div class="icon verified">
                    <?php echo ThemeFunctions::getInlineSvg('check'); ?>
                </div>
            <?php endif; ?>
        </div>
    </a>
</div>
