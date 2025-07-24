<?php

namespace ESC\Luna\Modules;

class FiltersModule
{
    public static function registerHooks(): void
    {
        add_filter('rank_math/frontend/robots', [__CLASS__, 'noindexArchivePage']);
        add_filter('rank_math/opengraph/facebook/image', [__CLASS__, 'rankMathModelImage']);

        add_filter('get_the_archive_title', [__CLASS__, 'customTaxPrefix']);

        add_filter('excerpt_length', [__CLASS__, 'excerptLength']);


        add_filter('excerpt_more', [__CLASS__, 'excerptMore']);
        add_filter('excerpt_length', [__CLASS__, 'excerptLength']);


        add_filter('the_content', [__CLASS__, 'replaceTitle']);
    }

    public static function excerptLength(): int
    {
        return 20;
    }

    public static function excerptMore(): string
    {
        return ' ...';
    }

    public static function noindexArchivePage(array $robots): array
    {
        if (isset($_GET['sf_paged'])) {
            $robots['index'] = 'noindex';
        }

        return $robots;
    }

    public static function rankMathModelImage($image): string
    {
        $gallery_images = get_field('model_photos');

        if ($gallery_images && isset($gallery_images[0])) {
            $image = wp_get_attachment_image_url($gallery_images[0]);
        }

        return $image;
    }

    public static function customTaxPrefix($title): string
    {
        if (is_category()) {
            $title = single_cat_title('', false);
        } elseif (is_tag()) {
            $title = single_tag_title('', false);
        }

        return $title;
    }

    public static function replaceTitle($content): string
    {
        if (get_field('title_disabled') === true) {
            if (stripos($content, '<h1') === false) {
                $pos_h2 = stripos($content, '<h2');
                if ($pos_h2 !== false) {
                    $h2_content = substr($content, $pos_h2);
                    $h2_content = preg_replace('/<h2([^>]*)>/', '<h1$1>', $h2_content, 1);
                    $content = substr_replace($content, $h2_content, $pos_h2);
                }
            }
        }

        return $content;
    }
}