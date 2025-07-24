<?php
use \ESC\Luna\ThemeFunctions;

$cards = get_field('cards');

if ($cards): ?>
    <section class="cards">

        <div class="wrapper">
                <?php foreach ($cards as $card):
                    $title = $card['title'] ?? '';
                    $description = $card['description'] ?? '';
                    $image = $card['image'] ?? null;
                    ?>
                    <div class="card">
                        <?php if ($image): ?>
                            <div class="image">
                                <img <?php ThemeFunctions::acfImageAttrs($image); ?>>
                            </div>
                        <?php endif; ?>

                        <?php if ($title): ?>
                            <h3 class="h5"><?php echo esc_html($title); ?></h3>
                        <?php endif; ?>

                        <?php if ($description): ?>
                            <p class="description"><?php echo esc_html($description); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
    </section>
<?php endif; ?>
