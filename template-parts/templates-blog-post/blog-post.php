<?php
use ESC\Luna\ThemeFunctions;

$post_id       = get_the_ID();
$link          = get_permalink($post_id);
$title         = get_the_title($post_id);
$limited_title = mb_strimwidth($title, 0, 60, '...');
$excerpt       = get_the_excerpt($post_id);
$date          = get_the_date();
?>
<a href="<?php echo esc_url($link); ?>" class="blog-post">
    <?php if (get_the_post_thumbnail()) { ?>
        <div class="post-thumbnail">
            <?php echo get_the_post_thumbnail(); ?>
        </div>
    <?php } ?>
    <div class="post-content">
        <h3 class="post-title"><?php echo esc_html($limited_title); ?></h3>
    </div>
</a>
