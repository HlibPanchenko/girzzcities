<?php

namespace ESC\Luna\Modules;

use WP_Post;

class LazyLoadModule
{
    /**
     * Register WordPress hooks.
     */
    public static function registerHooks(): void
    {
        add_filter('the_content', [__CLASS__, 'addImageResponsiveClass']);
        add_filter('get_the_archive_description', [__CLASS__, 'addImageResponsiveClass']);
        add_filter('wp_get_attachment_image_attributes', [__CLASS__, 'addLazyLoadToPostImages']);
        add_filter('wp_get_attachment_image_attributes', [__CLASS__, 'addNoLazyAttribute'], 20, 3);
    }

    /**
     * Add responsive class to images in the content.
     *
     * @param string|array $content
     * @return string|array
     */
    public static function addImageResponsiveClass($content): string
    {
        if (is_admin()) {
            return $content; // Оставляем HTML в редакторе Gutenberg без изменений
        }

        $pattern = '/<img([^>]+)>/i';

        return preg_replace_callback($pattern, function ($matches) {
            $imgTag = $matches[0];

            // Проверяем, содержит ли img class
            if (preg_match('/class=["\']([^"\']+)["\']/', $imgTag, $classMatch)) {
                $classAttribute = trim($classMatch[1] . ' lazyload');
                $imgTag = preg_replace('/class=["\'][^"\']+["\']/', 'class="' . esc_attr($classAttribute) . '"', $imgTag);
            } else {
                // Если class нет, добавляем его
                $imgTag = str_replace('<img', '<img class="lazyload"', $imgTag);
            }

            // Заменяем src на loading="lazy", но НЕ удаляем src
            $imgTag = str_replace('<img', '<img loading="lazy"', $imgTag);

            return $imgTag;
        }, $content);
    }


    /**
     * Replace image tag to include lazyload class.
     *
     * @param array $matches
     * @return string
     */
    private static function replaceImageTag($matches): string
    {
        if (empty($matches[0])) {
            return '';
        }

        $classAttribute = $matches[1] ?? '';
        $srcAttribute = $matches[2] ?? '';
        $altAttribute = $matches[3] ?? '';
        $titleAttribute = $matches[4] ?? '';
        $widthAttribute = $matches[5] ?? '';
        $heightAttribute = $matches[6] ?? '';

        if (str_contains($classAttribute, 'lazyload') || str_contains($classAttribute, 'no-lazy')) {
            return $matches[0];
        }

        return '<img class="' . esc_attr(trim($classAttribute . ' lazyload')) . '" data-src="' . esc_url($srcAttribute) . '" alt="' . esc_attr($altAttribute) . '" title="' . esc_attr($titleAttribute) . '" width="' . esc_attr($widthAttribute) . '" height="' . esc_attr($heightAttribute) . '" />'; // phpcs:ignore
    }

    /**
     * Add lazyload class to post images attributes.
     *
     * @param array $attr
     * @return array
     */
    public static function addLazyLoadToPostImages($attr): array
    {
        if (!isset($attr['class'])) {
            $attr['class'] = '';
        }

        // Проверяем наличие класса no-lazy
        if (str_contains($attr['class'], 'no-lazy')) {
            return $attr;
        }

        if (str_contains($attr['class'], 'custom-logo')) {
            return $attr;
        }

        $attr['class'] = trim($attr['class'] . ' lazyload');
        $attr['data-src'] = $attr['src'];
        $attr['src'] = '';

        return $attr;
    }

    /**
     * Remove lazyload class from no-lazy images attributes.
     *
     * @param array $attr
     * @param WP_Post $attachment
     * @param string|array $size
     * @return array
     */
    public static function addNoLazyAttribute($attr): array
    {
        if (str_contains($attr['class'], 'no-lazy')) {
            $classes = explode(' ', $attr['class']);
            $classes = array_diff($classes, ['lazyload']);
            $attr['class'] = implode(' ', $classes);
            unset($attr['data-src']);
        }

        return $attr;
    }
}