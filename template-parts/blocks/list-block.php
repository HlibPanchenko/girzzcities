<?php

use \ESC\Luna\ThemeFunctions;

$title = get_field('title');
$list = get_field('list');
?>

<section class="list-block">
    <div class="wrapper">
            <?php if ($title): ?>
                <h2><?php echo esc_html($title); ?></h2>
            <?php endif; ?>
            <?php if ($list && is_array($list)): ?>
                <ul>
                    <?php foreach ($list as $index => $item): ?>
                        <li class="<?php echo $index === 0 ? 'active' : ''; ?>">
                            <span class="list-index">
                                <?php printf('%02d', $index + 1); ?>
                            </span>
                            <div class="list-text">
                                <?php echo $item['item']; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
</section>
