<?php
use \ESC\Luna\ThemeFunctions;

$uniq_id = uniqid('advantages-block-');
$title = get_field('title');
$text = get_field('text');
$questions = get_field('elements');

$title_color = get_field('title_color');
$text_color = get_field('text_color');
$background_color = get_field('bg_color_items');
$icon_color = get_field('icon_color');
$bg_icon_color = get_field('bg_color_icon');
$title_item_color = get_field('title_item_color');
$text_item_color = get_field('text_item_color');
?>

<section class="wrapper advantages-block-section">
    <div id="<?php echo $uniq_id; ?>" class="advantages-block">
        <div class="column">
            <?php if (! empty($title)) {
                ?>
                <h2 class="title h3"><?php echo $title; ?></h2>
                <?php
            }
            if (! empty($text)) {
                ?>
                <div class="text">
                    <p><?php echo $text ?></p>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="column">
            <div class="advantages-block-items">
                <?php
                if (! empty($questions)) {
                    foreach ($questions as $question) {
                        $title = $question['title'];
                        $description = $question['description'];
                        $icon = $question['icon'];
                        ?>
                        <div class="ab-item">
                            <div class="icon"><?php echo ThemeFunctions::displayIcon($icon); ?></div>
                            <h3 class="title"><?php echo $title; ?></h3>
                            <p class="description"><?php echo $description; ?></p>
                       </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>

    <style>
        <?php
        echo <<<EOT
             #$uniq_id .title {
                color: $title_color;
             }
             #$uniq_id .text {
                color: $text_color;
             }
             #$uniq_id .ab-item  {
                background-color: $background_color;
             }
             #$uniq_id .ab-item .title  {
                color: $title_item_color;
             }
             #$uniq_id .ab-item .description {
                color: $text_item_color;
             }
             #$uniq_id .icon {
                background-color: $bg_icon_color;
             } 
             #$uniq_id .dashicons:before {
                color: $icon_color;
             }
        EOT;
        ?>
    </style>
