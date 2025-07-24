<!-- Block Statistics Block -->
<?php
$statistics_items = get_field('cards');
$statistics_title = get_field('title');

$card_color = get_field('card_color');
$card_bg = get_field('card_bg');

if ($statistics_items) {
    ?>

    <style>
        .statistics {
            --card-bg: <?php echo esc_attr($card_bg); ?>;
            --card-color: <?php echo esc_attr($card_color); ?>;
        }
    </style>

    <section class="statistics">
        <div class="container">
            <div class="wrapper">
                <?php if ($statistics_title) { ?>
                    <h2 class="">
                        <?php echo $statistics_title; ?>
                    </h2>
                <?php } ?>
                <?php if ($statistics_items) { ?>
                    <div class="statistics-items">
                        <?php foreach ($statistics_items as $item) { ?>
                            <?php if ($item['title'] && $item['text']) { ?>
                                <div class="statistics-item">
                                    <h3 class="statistics-label">
                                        <span class="statistics-number"><?php echo esc_html($item['title']); ?></span>
                                        <span class="statistics-text"><?php echo esc_html($item['text']); ?></span>
                                    </h3>
                                    <?php if ($item['description']) { ?>
                                        <div class="statistics-desc"><?php echo esc_html($item['description']); ?></div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>
