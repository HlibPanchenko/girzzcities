<?php
use ESC\Luna\ThemeFunctions;
use Kirki\Compatibility\Kirki;

$post_id = get_the_ID();
$link = get_permalink($post_id);
$title = get_the_title($post_id);

?>
<div class="latest-post-item">
    <div class="latest-post-content">
        <h2 class="latest-post-title"><?php echo $title; ?></h2>
        <div class="latest-post-excerpt">
            <?php ThemeFunctions::display_truncated_content(400); ?>
        </div>
        <a href="<?php echo $link; ?>" class="button"><?php echo esc_html__('Read More', 'pt-luna'); ?></a>
    </div>

    <?php if (get_the_post_thumbnail()) { ?>
        <div class="latest-post-thumbnail">
            <a href="<?php echo $link; ?>">
                <?php echo get_the_post_thumbnail(); ?>
            </a>
        </div>
    <?php } ?>
</div>
