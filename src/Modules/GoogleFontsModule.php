<?php

namespace ESC\Luna\Modules;

use Kirki\Compatibility\Kirki;

class GoogleFontsModule
{
    public static function registerHooks(): void
    {
        add_action('wp_head', [__CLASS__, 'inlineGoogleFonts'], 5);
    }

    public static function inlineGoogleFonts(): void
    {
        $google_fonts = Kirki::get_option('theme_fonts_link');
        $google_fonts = str_replace('&amp;', '&', $google_fonts);

        if (! $google_fonts) {
            return;
        }

        $transient_name = 'google-fonts-' . md5($google_fonts);

        // Get Inline Fonts.
        $css = get_transient($transient_name);

        if (! $css) {
            $response = wp_remote_get($google_fonts, [
                'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/603.3.8 (KHTML, like Gecko) Version/10.1.2 Safari/603.3.8' // phpcs:ignore Generic.Files.LineLength.TooLong
            ]);

            // Early exit if there was an error.
            if (is_wp_error($response)) {
                return;
            }

            // Get the CSS from our response.
            $css = wp_remote_retrieve_body($response);

            if (is_wp_error($css)) {
                return;
            }

            // Minify CSS.
            $css = preg_replace('/\/\*((?!\*\/).)*\*\//', '', $css);
            $css = preg_replace('/\s{2,}/', ' ', $css);
            $css = preg_replace('/\s*([:;{}])\s*/', '$1', $css);
            $css = preg_replace('/;}/', '}', $css);

            // Set Google Fonts Cache.
            if ($css) {
                set_transient($transient_name, $css, WEEK_IN_SECONDS);
            }
        }

        // Print Google Fonts.
        if ($css) {
            printf('<style>%s</style>', $css);
        }
    }
}