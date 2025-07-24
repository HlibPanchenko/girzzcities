<?php
$taxonomy = 'metro';

$terms = get_terms([
    'taxonomy' => $taxonomy,
    'hide_empty' => false,
    'orderby' => 'name',
    'order' => 'ASC',
]);

$first_letters = [];

if (!is_wp_error($terms)) {
    foreach ($terms as $term) {
        $first_letter = mb_substr($term->name, 0, 1);

        if (!isset($first_letters[$first_letter])) {
            $first_letters[$first_letter] = [];
        }

        $first_letters[$first_letter][] = [
            'term' => $term,
            'count' => $term->count,
        ];
    }

    ksort($first_letters);

    $total_terms = count($terms);
    $columns = 4;
    $terms_per_column = ceil($total_terms / $columns);
    $tolerance = 9;

    $columns_data = [];
    $current_column = [];
    $current_count = 0;
    $column_index = 0;

    foreach ($first_letters as $letter => $terms_group) {
        $letter_count = count($terms_group);
        $current_tolerance = ($column_index === 2) ? 0 : $tolerance;

        if ($current_count + $letter_count > $terms_per_column + $current_tolerance && !empty($current_column)) {
            $columns_data[] = $current_column;
            $current_column = [];
            $current_count = 0;
            $column_index++;
        }

        $current_column[$letter] = $terms_group;
        $current_count += $letter_count;
    }

    if (!empty($current_column)) {
        $columns_data[] = $current_column;
    }
    ?>
    <div class="metro-columns">
        <?php foreach ($columns_data as $column): ?>
            <div class="column">
                <?php foreach ($column as $first_letter => $terms_group): ?>
                    <span class="h3"><?php echo esc_html($first_letter); ?></span>
                    <ul>
                        <?php foreach ($terms_group as $term_data): ?>
                            <?php
                            $term = $term_data['term'];
                            $term_count = $term_data['count'];

                            printf(
                                '<li>
                                    <div>
                                        <a href="%1$s">%2$s</a>
                                    </div>
                                    <span>(%3$s)</span>
                                </li>',
                                esc_url(get_term_link($term)),
                                esc_html($term->name),
                                $term_count
                            );
                            ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
}
?>
