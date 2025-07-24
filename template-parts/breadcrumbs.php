
<?php
if (get_field('breadcrumbs_disabled') === false || empty(get_field('breadcrumbs_disabled'))) {
    ?>
    <div class="breadcrumbs-wrapper">
        <div class="container">
        <?php
        if (function_exists('rank_math_the_breadcrumbs')) {
            rank_math_the_breadcrumbs();
        } ?>
        </div>
    </div>
<?php
}
?>
