<?php
use ESC\Luna\ThemeFunctions;
use Kirki\Compatibility\Kirki;

$home = home_url();
$models = home_url() . '/models';
$area = home_url() . '/area';
$metro = home_url() . '/metro';

$phone_enable = Kirki::get_option('contacts_phone_enable');
$telegram_enable = Kirki::get_option('contacts_telegram_enable');
$whatsapp_enable = Kirki::get_option('contacts_whatsapp_enable');
$phone = Kirki::get_option('contacts_phone');
$telegram = Kirki::get_option('contacts_telegram');
$whatsapp = Kirki::get_option('contacts_whatsapp');
$mobile_tabs_enable = Kirki::get_option('mobile_tabs_enable');

$mobile_tabs_title_1 = Kirki::get_option('mobile_tabs_title_1');
$mobile_tabs_title_2 = Kirki::get_option('mobile_tabs_title_2');
$mobile_tabs_title_3 = Kirki::get_option('mobile_tabs_title_3');
$mobile_tabs_title_4 = Kirki::get_option('mobile_tabs_title_4');

$current_url = home_url(add_query_arg([], $wp->request));

if ($mobile_tabs_enable === true) {
    ?>
    <div class="nav">
        <div class="nav-slot">
            <a href="<?php echo $home; ?>" class="nav-link <?php echo ($current_url === $home) ? 'active' : ''; ?>">
                <?php echo ThemeFunctions::getInlineSvg('mobile-tabs/home'); ?>
                <span><?php echo $mobile_tabs_title_1 ?></span>
            </a>
        </div>
        <div class="nav-slot">
            <a href="<?php echo $models; ?>" class="nav-link <?php echo ($current_url === $models) ? 'active' : ''; ?>">
                <?php echo ThemeFunctions::getInlineSvg('mobile-tabs/models'); ?>
                <span><?php echo $mobile_tabs_title_2 ?></span>
            </a>
        </div>
        <div class="nav-slot">
            <?php
            if ($phone_enable || $telegram_enable || $whatsapp_enable) {
                ?>
                <div class="mobile-tabs-contacts">
                    <?php
                    if ($telegram_enable) {
                        ?>
                        <a href="<?php echo $telegram; ?>" class="mt-icon telegram">
                            <?php echo ThemeFunctions::getInlineSvg('telegram'); ?>
                        </a>
                        <?php
                    }
                    ?>
                    <?php
                    if ($phone_enable) {
                        ?>
                        <a href="tel:<?php echo $phone; ?>" class="mt-icon phone">
                            <?php echo ThemeFunctions::getInlineSvg('phone'); ?>
                        </a>
                        <?php
                    }
                    ?>
                    <?php
                    if ($whatsapp_enable) {
                        ?>
                        <a href="<?php echo $whatsapp; ?>" class="mt-icon whatsapp">
                            <?php echo ThemeFunctions::getInlineSvg('whatsapp'); ?>
                        </a>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
            ?>
            <button id="mobile-tabs-contact" class="floating-button">
            <span class="icon phone-icon active">
                <?php echo ThemeFunctions::getInlineSvg('phone'); ?>
            </span>
                <span class="icon close-icon">
                <?php echo ThemeFunctions::getInlineSvg('close'); ?>
            </span>
            </button>
        </div>
        <div class="nav-slot">
            <a href="<?php echo $area; ?>" class="nav-link <?php echo ($current_url === $area) ? 'active' : ''; ?>">
                <?php echo ThemeFunctions::getInlineSvg('mobile-tabs/area'); ?>
                <span><?php echo $mobile_tabs_title_3 ?></span>
            </a>
        </div>
        <div class="nav-slot">
            <a href="<?php echo $metro; ?>" class="nav-link <?php echo ($current_url === $metro) ? 'active' : ''; ?>">
                <?php echo ThemeFunctions::getInlineSvg('mobile-tabs/metro'); ?>
                <span><?php echo $mobile_tabs_title_4 ?></span>
            </a>
        </div>
    </div>
    <?php
}
?>


