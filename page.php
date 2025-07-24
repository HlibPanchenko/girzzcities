<?php
/*******
 ****Template Name: Content Page
 */


get_header();

$title_disabled = get_field('title_disabled');

$requested_city = get_query_var('city'); // из URL

$page_cities = get_the_terms(get_the_ID(), 'city');
$city_matches = false;

if (!empty($page_cities) && !is_wp_error($page_cities)) {
    foreach ($page_cities as $term) {
        if ($term->slug === $requested_city) {
            $city_matches = true;
            break;
        }
    }
}

if (!$city_matches) {
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    get_template_part(404);
    exit;
}
?>

<main id="primary" class="homepage">
    <div class="container">
        <?php
        if (!$title_disabled) { ?>
            <section class="wrapper">
                <?php
                if ($title_disabled === false || empty($title_disabled)) { ?>
                    <h1 class="title"><?php the_title(); ?></h1>
                <?php } ?>
            </section>
        <?php } ?>

        <section class="wrapper">
            <?php
            the_content();
            ?>
        </section>
    </div>
</main>


<?php get_footer(); ?>
