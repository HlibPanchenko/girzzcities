<?php
namespace ESC\Luna\Modules;

class SeoModule
{
    public static function registerHooks(): void
    {
        add_filter('the_content', [self::class, 'injectFaqHeading'], 20);
    }

    public static function injectFaqHeading($content): string
    {
        if (strpos($content, 'rank-math-list') !== false) {
            $seo_title = get_field('rm_seo_title', 'option');

            if (!empty($seo_title)) {
                $heading = '<h2 class="rank-math-block__title">' . esc_html($seo_title) . '</h2>';
                $content = preg_replace(
                    '/(<div[^>]+class="[^"]*rank-math-list[^"]*"[^>]*>)/i',
                    $heading . '$1',
                    $content,
                    1
                );
            }
        }

        return $content;
    }
}