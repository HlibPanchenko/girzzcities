<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Devochki
 */

get_header();
?>

    <main id="primary" class="site-main">
        <?php if (have_posts()) { ?>
            <header class="page-header">
                <?php
                the_archive_title('<h1 class="page-title">', '</h1>');
                if ( !is_paged() ) {
                 the_archive_description();
                }
                ?>
            </header>

            <?php
            while (have_posts()) {
                the_post();
                get_template_part('template-parts/content', get_post_type());
            }

            the_posts_navigation();
        } else {
            get_template_part('template-parts/content', 'none');
        }
        ?>
    </main>

<?php
get_sidebar();
get_footer();
