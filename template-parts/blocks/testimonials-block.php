<?php

use \ESC\Luna\ThemeFunctions;

$title = get_field('title');
$testimonials = get_field('testimonials');
$background_color = get_field('background_color');
$color = get_field('color');
?>
<style>
    .testimonials {
        --background: <?php echo esc_attr($background_color); ?>;
        --color: <?php echo esc_attr($color); ?>;
    }
</style>

<section class="testimonials">
    <div class="wrapper">
        <div class="columns">
            <div class="column column--left">
                <?php if ($title): ?>
                    <h2><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
            </div>

            <div class="column column--right">
                <?php if ($testimonials): ?>
                    <div class="testimonials-list">
                        <?php foreach ($testimonials as $testimonial): ?>
                            <?php if (!empty($testimonial['text'])): ?>
                                <div class="testimonial-item">

                                    <div class="rating">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?php echo ThemeFunctions::getInlineSvg('testimonial-star'); ?>
                                        <?php endfor; ?>
                                    </div>

                                    <p><?php echo esc_html($testimonial['text']); ?></p>

                                    <?php if (!empty($testimonial['author'])): ?>
                                        <div class="author">
                                            <?php echo esc_html($testimonial['author']); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
