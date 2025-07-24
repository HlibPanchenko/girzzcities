<?php

use \ESC\Luna\ThemeFunctions;

$title = get_field('title');
$questions = get_field('questions');

$background = get_field('background');
$color = get_field('color');
$accent_color = get_field('accent_color');

?>

<style>
    .faq-block {
        --faq-background-color: <?php echo esc_attr($background); ?>;
        --faq-text-color: <?php echo esc_attr($color); ?>;
        --faq-accent-color: <?php echo esc_attr($accent_color); ?>;
    }
</style>
<section class="faq-block">
    <div class="wrapper">
            <?php if ($title): ?>
                <h3 class="h2"><?php echo esc_html($title); ?></h3>
            <?php endif; ?>
            <?php if ($questions && is_array($questions)): ?>
                <div class="faq-list">
                    <?php foreach ($questions as $index => $item): ?>
                        <div class="faq-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <div class="faq-question">
                                <?php echo esc_html($item['question']); ?>
                                <span class="icon">
                                <?php echo ThemeFunctions::getInlineSvg('plus') ?>

                            </span>
                            </div>
                            <div class="faq-answer">
                                <?php echo wp_kses_post($item['answer']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
</section>
