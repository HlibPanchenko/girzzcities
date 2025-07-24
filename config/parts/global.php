<?php
use ESC\Luna\ThemeFunctions;

new \Kirki\Panel(
    'theme_settings',
    [
        'priority'    => 10,
        'title'       => esc_html__('Theme Settings', 'kirki'),
    ]
);

new \Kirki\Section(
    'global_settings',
    [
        'title'       => esc_html__('Global Settings', 'kirki'),
        'description' => esc_html__('Globals Setting', 'kirki'),
        'panel'       => 'theme_settings',
        'priority'    => 160,
        'tabs'  => [
            'general' => [
                'label' => esc_html__( 'General', 'kirki' ),
            ],
            'fonts'  => [
                'label' => esc_html__( 'Fonts', 'kirki' ),
            ],
            'alt'  => [
                'label' => esc_html__( 'Alt Text', 'kirki' ),
            ],
        ],
    ]
);

new \Kirki\Field\Textarea(
    [
        'settings' => 'theme_fonts_link',
        'label'    => esc_html__('Fonts Link', 'kirki'),
        'section'  => 'global_settings',
        'tab'      => 'fonts',
        'default'  => 'https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap',
        'priority' => 10,
    ]
);

new \Kirki\Field\Text(
    [
        'settings' => 'theme_fonts_heading',
        'label'    => esc_html__('Heading Font', 'kirki'),
        'section'  => 'global_settings',
        'tab'      => 'fonts',
        'default'  => esc_html__("Nunito", 'kirki'),
        'priority' => 10,
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--font-heading-family',
            ],
        ],
    ]
);

new \Kirki\Field\Text(
    [
        'settings' => 'theme_fonts_content',
        'label'    => esc_html__('Content Font', 'kirki'),
        'section'  => 'global_settings',
        'tab'      => 'fonts',
        'default'  => esc_html__("Nunito", 'kirki'),
        'priority' => 10,
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--font-content-family',
            ],
        ],
    ]
);

new \Kirki\Field\Textarea(
    [
        'settings' => 'models_alt_spin_text',
        'label'    => esc_html__('Photos Alt Spintax Text', 'kirki'),
        'section'  => 'global_settings',
        'tab'      => 'alt',
        'default'  => esc_html__('', 'kirki'),
        'priority' => 10,
    ]
);
