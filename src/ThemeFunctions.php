<?php

namespace ESC\Luna;

use ariColor;

class ThemeFunctions
{
    public static function hexToRGB($color): string
    {
        if (!is_string($color)) {
            return '0, 0, 0';
        }

        if (!class_exists(ariColor::class)) {
            return $color;
        }

        $ari = ariColor::newColor($color);

        if (isset($ari->red, $ari->green, $ari->blue)) {
            return "{$ari->red}, {$ari->green}, {$ari->blue}";
        }

        return '0, 0, 0';
    }
    public static function getInlineSvg($name): false|string
    {
        if ($name) {
            $file_path = get_template_directory() . '/assets/icons/' . $name . '.svg';

            if (file_exists($file_path)) {
                return file_get_contents($file_path);
            }
        }
        return '';
    }
    public static function acf_image_src($image_id, $max_width = "100%", $image_size = "full"){

        // check the image ID is not blank
        if($image_id != '') {

            // set the default src image size
            $image_src = wp_get_attachment_image_url( $image_id, $image_size );

            // set the srcset with various image sizes
            $image_srcset = wp_get_attachment_image_srcset( $image_id, $image_size );

            // generate the markup for the responsive image
            return 'src="'.$image_src.'" srcset="'.$image_srcset.'" sizes="(max-width: '.$max_width.') 100vw, '.$max_width.'"';
        }
    }
    public static function acfImageAttrs($image) {
        if(is_array($image))
        {
            $url = $image['url'];
            $alt = $image['alt'] ? $image['alt'] : $image['title'];
            echo 'src="' . esc_url($url) . '" alt="' . esc_attr($alt) . '"';
        }
        else {
            $image_id = (int) $image;
            echo acf_image_src($image) . ' alt="' . get_the_title($image) . '"';
        }
    }
    public static function generateVideoPreviewFromUrl($video_url): bool|string
    {
        $upload_dir = wp_upload_dir();
        $video_path = parse_url($video_url, PHP_URL_PATH);
        $video_path = $_SERVER['DOCUMENT_ROOT'] . $video_path;

        $output_image = $upload_dir['basedir'] . '/video_preview_' . md5($video_url) . '.jpg';

        if (!file_exists($video_path)) {
            return false;
        }

        $command = "ffmpeg -i $video_path -vf \"select=eq(n\\,0)\" -vsync vfr $output_image";
        exec($command, $output, $return_var);

        if ($return_var === 0 && file_exists($output_image)) {
            return $upload_dir['baseurl'] . '/video_preview_' . md5($video_url) . '.jpg';
        } else {
            return false;
        }
    }
    public static function displayIcon($icon) {
        if (empty($icon)) {
            return '';
        }

        // Dashicons
        if (isset($icon['type']) && 'dashicons' === $icon['type']) {
            return '<div class="dashicons ' . esc_attr($icon['value']) . '"></div>';
        }

        // Media Library
        if (isset($icon['type']) && 'media_library' === $icon['type']) {
            $attachment_data = $icon['value'];

            if ($attachment_data) {
                $attachment_id = $attachment_data['ID'];
                $attachment_url = $attachment_data['url'];
                $mime_type = get_post_mime_type($attachment_id);

                if ($mime_type === 'image/svg+xml') {
                    return '<img src="' . esc_url($attachment_url) . '" alt="Icon">';
                } else {
                    return wp_get_attachment_image($attachment_id, 'thumbnail');
                }
            }
        }

        // URL
        if (isset($icon['type']) && 'url' === $icon['type']) {
            $url = $icon['value'];
            return '<img src="' . esc_url($url) . '" alt="Icon">';
        }
        return '';
    }
    public static function display_truncated_content($limit = 200) {
        $content = get_the_content();
        $content = wp_strip_all_tags($content);
        if (mb_strlen($content) > $limit) {
            $content = mb_substr($content, 0, $limit) . '...';
        }
        echo $content;
    }

}