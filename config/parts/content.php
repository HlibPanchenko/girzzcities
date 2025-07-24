<?php
use ESC\Luna\ThemeFunctions;

new \Kirki\Section(
    'content_settings',
    [
        'title'       => esc_html__('Content Settings', 'kirki'),
        'panel'       => 'theme_settings',
        'priority'    => 160,
        'tabs'  => [
            'general' => [
                'label' => esc_html__( 'General', 'kirki' ),
            ],
            'colors' => [
                'label' => esc_html__( 'Colors', 'kirki' ),
            ],
            'fonts'  => [
                'label' => esc_html__( 'Fonts', 'kirki' ),
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'content_background_color',
        'label'       => __('Background Color', 'kirki'),
        'section'     => 'content_settings',
        'tab'         => 'general',
        'default'     => '#171717',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--content-bg-color',
            ],
            [
                'element'  => ':root',
                'property' => '--content-bg-color-rgb',
                'sanitize_callback' => [ThemeFunctions::class, 'hexToRGB']
            ]
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'content_secondary_color',
        'label'       => __('Secondary Color', 'kirki'),
        'section'     => 'content_settings',
        'tab'         => 'general',
        'default'     => '#dbdbdb',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--content-secondary-color',
            ],
            [
                'element'  => ':root',
                'property' => '--content-secondary-color-rgb',
                'sanitize_callback' => [ThemeFunctions::class, 'hexToRGB']
            ]
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'content_accent_color',
        'label'       => __('Accent Color', 'kirki'),
        'section'     => 'content_settings',
        'default'     => '#e20f0f',
        'tab'      => 'colors',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--content-accent-color',
            ],
            [
                'element'  => ':root',
                'property' => '--content-accent-color-rgb',
                'sanitize_callback' => [ThemeFunctions::class, 'hexToRGB']
            ],
        ]
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'content_heading_color',
        'label'       => __('Heading Color', 'kirki'),
        'section'     => 'content_settings',
        'tab'         => 'fonts',
        'default'     => '#ffffff',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--content-heading-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'content_text_color',
        'label'       => __('Text Color', 'kirki'),
        'section'     => 'content_settings',
        'tab'         => 'fonts',
        'default'     => '#ffffff',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--content-text-color',
            ],
            [
                'element'  => ':root',
                'property' => '--content-text-color-rgb',
                'sanitize_callback' => [ThemeFunctions::class, 'hexToRGB']
            ]
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'content_link_color',
        'label'       => __('Link Color', 'kirki'),
        'section'     => 'content_settings',
        'tab'         => 'fonts',
        'default'     => '#E20F0F',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--content-link-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'content_hover_link_color',
        'label'       => __('Hover Link Color', 'kirki'),
        'section'     => 'content_settings',
        'tab'         => 'fonts',
        'default'     => '#E20F0F',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--content-hover-link-color',
            ],
        ],
    ]
);

new \Kirki\Field\Radio_Buttonset(
    [
        'settings'    => 'content_border-radius',
        'label'       => esc_html__( 'Border radius', 'kirki' ),
        'section'     => 'content_settings',
        'tab'         => 'general',
        'default'     => 'square',
        'priority'    => 10,
        'choices'     => [
            '0px'   => esc_html__( 'Square', 'kirki' ),
            '10px' => esc_html__( 'Rounded', 'kirki' ),
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--content_border-radius',
            ],
        ],
    ]
);
