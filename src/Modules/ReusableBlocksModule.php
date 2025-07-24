<?php

namespace ESC\Luna\Modules;

class ReusableBlocksModule
{
    public static function registerHooks(): void
    {
        add_action('admin_menu', [__CLASS__, 'addReusablePageInMenu']);
        add_action('init', [__CLASS__, 'register']);
    }

    public static function addReusablePageInMenu(): void
    {
        add_menu_page(
            'Reusable Blocks',
            'Reusable Blocks',
            'edit_posts',
            'edit.php?post_type=wp_block',
            '',
            'dashicons-editor-kitchensink',
            30
        );
    }

    public static function register(): void
    {
        add_shortcode('esc-reusable-block', [__CLASS__, 'content']);
    }

    /**
     * @param string|array{id: string} $atts
     * @return string
     */
    public static function content(array $atts): string
    {
        $atts = shortcode_atts([
            'id' => '',
        ], (array) $atts);

        if (! $atts['id']) {
            return '';
        }

        return do_shortcode(
            render_block_core_block([
                'ref' => $atts['id']
            ])
        );
    }
}