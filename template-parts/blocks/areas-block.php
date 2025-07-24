<?php
use ESC\Luna\ThemeFunctions;

$taxonomy = 'area';

$terms = get_terms([
    'taxonomy' => $taxonomy,
    'hide_empty' => false,
    'orderby' => 'name',
    'order' => 'ASC',
]);

if (!is_wp_error($terms)) {
    $terms_by_parent = [];
    $total_terms = 0;

    foreach ($terms as $term) {
        $parent_term = get_term($term->parent, $taxonomy);

        if ($parent_term instanceof WP_Term) {
            if (!isset($terms_by_parent[$parent_term->name])) {
                $terms_by_parent[$parent_term->name] = [];
            }

            $terms_by_parent[$parent_term->name][] = $term;
            $total_terms++;
        }
    }

    ksort($terms_by_parent);

    $columns = 4;
    $terms_per_column = ceil($total_terms / $columns);
    $tolerance = 5;

    $columns_data = [];
    $current_column = [];
    $current_count = 0;
    $column_index = 0;

    foreach ($terms_by_parent as $parent_term_name => $terms) {
        $parent_count = count($terms);
        $current_tolerance = ($column_index === 2) ? 0 : $tolerance;

        if ($current_count + $parent_count > $terms_per_column + $current_tolerance && !empty($current_column)) {
            $columns_data[] = $current_column;
            $current_column = [];
            $current_count = 0;
            $column_index++;
        }

        $current_column[$parent_term_name] = $terms;
        $current_count += $parent_count;
    }

    if (!empty($current_column)) {
        $columns_data[] = $current_column;
    }

    ?>
    <div class="area-columns">
        <?php foreach ($columns_data as $column): ?>
            <div class="column">
                <?php foreach ($column as $parent_term_name => $terms): ?>
                    <?php if ($parent_term_name !== ''):
                        $parent_term = get_term_by('name', $parent_term_name, $taxonomy);
                        $parent_term_link = get_term_link($parent_term);
                        ?>
                        <h3>
                            <a href="<?php echo esc_url($parent_term_link); ?>">
                                <?php echo esc_html($parent_term_name); ?>
                            </a>
                        </h3>
                    <?php endif; ?>
                    <ul>
                        <?php foreach ($terms as $term): ?>
                            <li>
                                <a href="<?php echo esc_url(get_term_link($term)); ?>">
                                    <?php echo esc_html($term->name); ?>
                                </a>
                                <span>(<?php echo $term->count; ?>)</span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
}
?>
