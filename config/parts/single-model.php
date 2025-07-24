<?php
use ESC\Luna\ThemeFunctions;

new \Kirki\Section(
    'single_model_settings',
    [
        'title'       => esc_html__('Single Model Settings', 'kirki'),
        'description' => esc_html__('My Section with Single Model Settings.', 'kirki'),
        'panel'       => 'theme_settings',
        'tabs'  => [
            'general' => [
                'label' => esc_html__( 'General', 'kirki' ),
            ],
        ],
        'priority'    => 160,
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'single_accent_color',
        'label'       => __('Single Model Accent Color', 'kirki'),
        'section'     => 'single_model_settings',
        'default'     => '#f29d38',
        'tab'      => 'general',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--single_accent_color',
            ],
            [
                'element'  => ':root',
                'property' => '--single_accent_color-rgb',
                'sanitize_callback' => [ThemeFunctions::class, 'hexToRGB']
            ]
        ]
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'single_model_title_color',
        'label'       => __('Title Color', 'kirki'),
        'section'     => 'single_model_settings',
        'default'     => '#fff',
        'tab'      => 'general',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--single_model_title_color',
            ],
        ]
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'single_model_text_color',
        'label'       => __('Text Color', 'kirki'),
        'section'     => 'single_model_settings',
        'default'     => '#fff',
        'tab'      => 'general',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--single_model_text_color',
            ],
        ]
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'single_model_text_color_secondary',
        'label'       => __('Text Color Secondary', 'kirki'),
        'section'     => 'single_model_settings',
        'default'     => '#8f8f8f',
        'tab'      => 'general',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--single_model_text_color_secondary',
            ],
        ]
    ]
);

new \Kirki\Field\Radio_Buttonset(
    [
        'settings'    => 'single_model_show_prices',
        'label'       => esc_html__( 'Show Price Dropdown', 'kirki' ),
        'section'     => 'single_model_settings',
        'default'     => 'show',
        'tab'      => 'general',
        'choices'     => [
            'show'   => esc_html__( 'Show', 'kirki' ),
            'hide' => esc_html__( 'Hide', 'kirki' ),
        ],
    ]
);

new \Kirki\Field\Checkbox_Toggle(
    [
        'settings'    => 'single_model_services_parent_terms',
        'label'       => esc_html__('Show parent terms', 'kirki'),
        'section'     => 'single_model_settings',
        'default'     => '0',
        'priority'    => 10,
    ]
);
