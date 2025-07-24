<?php
use \ESC\Luna\ThemeFunctions;

$uniq_id = uniqid('cta-');

$title = get_field('title', 'option');
$button = get_field('button', 'option');
$image = get_field('image', 'option');
$text_color = get_field('text-color', 'option');
$text_accent_color = get_field('text-accent-color', 'option');
$background_accent_color= get_field('background-accent-color', 'option');
?>

<section class="cta" id="<?php echo $uniq_id; ?>">
    <div class="container">
        <div class="wrapper">
            <div class="col col--content">
                <div class="content">

                    <?php if ($title): ?>
                        <?php echo $title; ?>
                    <?php endif; ?>

                  <?php if ($button): ?>
					<a href="<?php echo esc_url($button['url']); ?>" class="button">
						<?php echo esc_html($button['title']); ?>
					</a>
				<?php endif; ?>

                </div>
            </div>
            <div class="col col--image">
                <?php if ($image): ?>
                    <div class="image">
                        <div class="image-wrapper">
                            <img class="no-lazy image_desktop" src="<?php echo esc_url($image['url']); ?>" alt="Cta block image">
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<style>
    <?php
    echo <<<EOT
         #$uniq_id h3 {
            color: $text_color;
         }
         
         #$uniq_id em {
            color: $text_accent_color;
         }
         
         #$uniq_id em:after {
            background-color: $background_accent_color;
         }
         
         #$uniq_id p {
            color: $text_color;
         }
        
    EOT;
    ?>
</style>
