<?php
new \Kirki\Section(
    'button_settings',
    [
        'title'       => esc_html__('Button Settings', 'kirki'),
        'description' => esc_html__('My Section Description.', 'kirki'),
        'panel'       => 'theme_settings',
        'priority'    => 160,
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'button_background_color',
        'label'       => __('Background Color', 'kirki'),
        'section'     => 'button_settings',
        'default'     => '#000000',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--button-bg-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'button_text_color',
        'label'       => __('Text Color', 'kirki'),
        'section'     => 'button_settings',
        'default'     => '#ffffff',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--button-text-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'button_border_color',
        'label'       => __('Border Color', 'kirki'),
        'section'     => 'button_settings',
        'default'     => '#000000',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--button-border-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'button_hover_background_color',
        'label'       => __('Hover Background Color', 'kirki'),
        'section'     => 'button_settings',
        'default'     => '#ffffff',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--button-hover-bg-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'button_hover_color',
        'label'       => __('Hover Color', 'kirki'),
        'section'     => 'button_settings',
        'default'     => '#000000',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--button-hover-color',
            ],
        ],
    ]
);

new \Kirki\Field\Radio_Buttonset(
    [
        'settings'    => 'button_border-radius',
        'label'       => esc_html__( 'Shape', 'kirki' ),
        'section'     => 'button_settings',
        'default'     => 'square',
        'priority'    => 10,
        'choices'     => [
            '0px'   => esc_html__( 'Square', 'kirki' ),
            '100px' => esc_html__( 'Rounded', 'kirki' ),
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--button_border-radius',
            ],
        ],
    ]
);