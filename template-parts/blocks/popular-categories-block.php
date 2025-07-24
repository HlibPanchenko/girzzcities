<?php
use \ESC\Luna\ThemeFunctions;

$title = get_field('title');
$category = get_field('category');
$placeholder = get_template_directory_uri() . '/assets/icons/image-placeholder.jpeg';
?>

<section class="popular-categories">
    <div class="wrapper">
            <?php if ($title) { ?>
                <h2 class="title"><?php echo esc_html($title); ?></h2>
            <?php } ?>
            <?php if (!empty($category) && is_array($category)) { ?>
                <div class="category-grid">
                    <?php foreach ($category as $term_id) {
                        $term = get_term($term_id);
                        if (!$term || is_wp_error($term)) {
                            continue;
                        }
                        $term_link = get_term_link($term);
                        $term_name = esc_html($term->name);
                        $term_image_id = get_field('option_image', 'term_' . $term_id);
                        $term_image_url = $term_image_id ? wp_get_attachment_url($term_image_id) : $placeholder;
                        ?>
                            <a href="<?php echo esc_url($term_link); ?>" class="category-item">
                                <div class="category-item__img">
                                    <img src="<?php echo esc_url($term_image_url); ?>" alt="<?php echo esc_attr($term_name); ?>">
                                </div>
                                <h3 class="category-item__title"><?php echo $term_name; ?></h3>
                            </a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
</section>
