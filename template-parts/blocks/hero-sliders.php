<?php
$uniq_id = uniqid('hero-slider-block-', false);

$questions = get_field('slides');
$accent_color = get_field('accent_color');
$title_color = get_field('title_color');
$text_color = get_field('text_color');
$background_color = get_field('background_color');
?>

<section id="<?php echo $uniq_id; ?>" class="hero-swiper">
    <div id="heroSwiper" class="hero-swiper-container">
        <div class="swiper-wrapper">
            <?php
            if (! empty($questions)) {
                foreach ($questions as $key => $question) {
                    $title = $question['title'];
                    $sub_title = $question['sub_title'];
                    $text = $question['text'];
                    $link_url = $question['link']['url'];
                    $link_title = $question['link']['title'];
                    ?>

                    <div class="swiper-slide">
                        <div class="container">
                            <div class="info-container">
                                <div class="sub-title"><?php echo $sub_title; ?></div>
                                <div class="title h3"><?php echo $title; ?></div>
                                <div class="text">
                                    <p><?php echo $text; ?></p>
                                </div>
                                <a href="<?php echo $link_url; ?>" class="button">
                                    <?php echo $link_title; ?>
                                </a>
                            </div>
                        </div>

                        <?php
                        echo wp_get_attachment_image(
                            $question['background_image'],
                            'full',
                            false,
                            ['class' => 'no-lazy']
                        )
                        ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <div class="hero-swiper-pagination"></div>
    </div>
</section>

<style>
    <?php
    echo <<<EOT
         #$uniq_id .title  {
            color: $title_color;
         }
         #$uniq_id .sub-title  {
            color: rgb($accent_color[red], $accent_color[green], $accent_color[blue]);
            background-color: rgba($accent_color[red], $accent_color[green], $accent_color[blue], .2);
         }
         #$uniq_id .text  {
            color: $text_color;
         }
         #$uniq_id .button  {
            background-color: rgb($accent_color[red], $accent_color[green], $accent_color[blue]);
            color: $background_color;
         }
         #$uniq_id .swiper-pagination-bullet  {
            background-color: $background_color;
            color: rgb($accent_color[red], $accent_color[green], $accent_color[blue]);
         }
         #$uniq_id .swiper-pagination-bullet-active  {
            background-color: rgb($accent_color[red], $accent_color[green], $accent_color[blue]);
            color: $background_color;
         }
         #$uniq_id .info-container {
            background-color: $background_color;
         }
    EOT;
    ?>
</style>