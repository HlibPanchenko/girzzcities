<?php

namespace ESC\Luna\Modules;

use Kirki\Compatibility\Kirki;

class PhotosMetaModule
{
    public static function registerHooks(): void
    {
        add_action('save_post', [__CLASS__, 'addPhotosMeta']);
    }

    private static function generateSpinText($spin_syntax, $post_id): string
    {
        $pattern = '/\{([^{}]+)\}/';

        $replacement = function ($matches) use ($post_id) {
            if ($matches[1] === 'NAME') {
                return get_the_title($post_id);
            }
            $options = explode('|', $matches[1]);
            return $options[array_rand($options)];
        };

        return preg_replace_callback($pattern, $replacement, $spin_syntax);
    }

    public static function addPhotosMeta($post_id): void
    {
        if (! empty(get_post_type($post_id) === 'models')) {
            $photos = get_field('model_photos', $post_id);

            if (Kirki::get_option('models_alt_spin_text')) {
                $spin_text = Kirki::get_option('models_alt_spin_text');

                if (! empty($photos)) {
                    foreach ($photos as $photo) {
                        if (! get_post_meta($photo, '_wp_attachment_image_alt', true)) {
                            update_post_meta(
                                $photo,
                                '_wp_attachment_image_alt',
                                self::generateSpinText($spin_text, $post_id)
                            );
                        }
                    }
                }
            }
        }
    }
}
