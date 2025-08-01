<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Devochki
 */

get_header();
?>
    <main id="primary" class="site-main">
        <?php
        if (have_posts()) {
            if (is_home() && ! is_front_page()) {
                ?>
                <header>
                    <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                </header>
                <?php
            }

            while (have_posts()) {
                the_post();
                get_template_part('template-parts/content', get_post_type());
            }

        } else {
            get_template_part('template-parts/content', 'none');
        }
        ?>
    </main>
<?php
get_sidebar();
get_footer();
