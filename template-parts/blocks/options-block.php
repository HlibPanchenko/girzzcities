<?php
$uniq_id = uniqid('options-block-', true);
$taxonomy = 'options';
$title = get_field('title');

$terms = get_terms([
    'taxonomy'  => $taxonomy,
    'orderby'   => 'name',
    'order'     => 'DESC',
    'parent'    => 0,
    'hide_empty'=> false
]);
?>

<div id="<?php echo $uniq_id; ?>" class="options-block" >
    <?php
    if (!empty($title)) {
        ?>
        <h2 class="title"><?php echo $title; ?></h2>
        <?php
    }

    if (!empty($terms) && !is_wp_error($terms)) { ?>
        <div class="taxonomy-options">
            <ul class="taxonomy-list <?php echo count($terms) > 10 ? 'two-columns' : ''; ?>">
                <?php foreach ($terms as $term) {
                    $term_id = esc_attr($term->term_id);
                    $term_url = esc_url(get_term_link($term));
                    $term_name = esc_html($term->name);
                    $image_url = '';


                    $term_image = get_field('option_image', 'term_' . $term_id);

                    if ($term_image) {
                        $image_url = wp_get_attachment_url($term_image);
                    } else {
                        $args = [
                            'posts_per_page' => 1,
                            'post_type' => 'models',
                            'tax_query' => [
                                [
                                    'taxonomy' => $term->taxonomy,
                                    'field' => 'id',
                                    'terms' => $term_id,
                                ],
                            ],
                        ];
                        $query = new WP_Query($args);

                        if ($query->have_posts()) {
                            $query->the_post();
                            $post_id = get_the_ID();
                            $image_ids = get_field('model_photos', $post_id);

                            if ($image_ids) {
                                $image_url = wp_get_attachment_url($image_ids[0]);
                            }
                            wp_reset_postdata();
                        }
                    }
                    ?>
                    <li class="taxonomy-item" value="<?php echo $term_id; ?>">
                        <div class="option-image">
                            <?php if ($image_url) { ?>
                                <img class="no-lazy" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($term_name); ?>">
                            <?php } ?>
                        </div>
                        <a class="option-link" href="<?php echo $term_url; ?>"><?php echo $term_name; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
</div>

<style>
    <?php
    echo <<<EOT
         #$uniq_id.options-block {
           
         }
    EOT;
    ?>
</style>
