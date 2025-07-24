<?php
use ESC\Luna\ThemeFunctions;
use Kirki\Compatibility\Kirki;

$show_parent_terms = Kirki::get_option('archive_services_parent_terms');
?>
<div class="services-block">
    <div class="services-wrap">
        <?php
        $taxonomy = 'services';

        if ($show_parent_terms) {
            // With groups and titles
            $terms = get_terms([
                'taxonomy' => $taxonomy,
                'orderby' => 'name',
                'order' => 'DESC',
                'parent' => 0,
                'hide_empty' => false,
            ]);

            if (!function_exists('compare_term_children_count')) {
                function compare_term_children_count($a, $b)
                {
                    $a_children = get_term_children($a->term_id, $a->taxonomy);
                    $b_children = get_term_children($b->term_id, $b->taxonomy);
                    return count($b_children) - count($a_children);
                }
            }

            usort($terms, 'compare_term_children_count');

            if (!empty($terms) && !is_wp_error($terms)) {
                $total_terms = count($terms);
                $columns = 4;
                $terms_per_column = ceil($total_terms / $columns);
                $columns_data = array_chunk($terms, $terms_per_column);

                foreach ($columns_data as $column): ?>
                    <div class="column">
                        <?php foreach ($column as $term): ?>
                            <div class="services-part">
                                <div class="parent-title h3"><?php echo esc_html($term->name); ?></div>
                                <ul class="services-list">
                                    <?php
                                    $children = get_terms([
                                        'taxonomy' => $taxonomy,
                                        'parent' => $term->term_id,
                                        'hide_empty' => false,
                                    ]);

                                    foreach ($children as $child_term): ?>
                                        <li>
                                            <a href="<?php echo esc_url(get_term_link($child_term)); ?>">
                                                <?php echo esc_html($child_term->name); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach;
            }
        } else {
            // without groups with titles
            $all_terms = get_terms([
                'taxonomy' => $taxonomy,
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => false,
            ]);

            if (!empty($all_terms) && !is_wp_error($all_terms)) {
                $total_terms = count($all_terms);
                $columns = 4;
                $terms_per_column = ceil($total_terms / $columns);
                $columns_data = array_chunk($all_terms, $terms_per_column);

                foreach ($columns_data as $column): ?>
                    <div class="column">
                        <ul class="services-list">
                            <?php foreach ($column as $term): ?>
                                <li>
                                    <a href="<?php echo esc_url(get_term_link($term)); ?>">
                                        <?php echo esc_html($term->name); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach;
            }
        }
        ?>
    </div>
</div>
