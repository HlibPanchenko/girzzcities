<?php

get_header();

$title_disabled = get_field('title_disabled');
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
