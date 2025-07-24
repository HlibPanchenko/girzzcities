<?php

new \Kirki\Section(
    'popup_settings',
    [
        'title'       => esc_html__('Popup Settings', 'kirki'),
        'description' => esc_html__('My Section Description.', 'kirki'),
        'panel'       => 'theme_settings',
        'priority'    => 160,
    ]
);

new \Kirki\Field\Checkbox_Toggle(
    [
        'settings'    => 'popup_enable',
        'label'       => esc_html__('Enable Popup', 'kirki'),
        'section'     => 'popup_settings',
        'default'     => '0',
        'priority'    => 10,
    ]
);

new \Kirki\Field\Number(
    [
        'settings' => 'popup_delay',
        'label'    => esc_html__('Delay', 'kirki'),
        'section'  => 'popup_settings',
        'default'  => 10,
        'choices'  => [
            'min'  => 0,
            'max'  => 300,
            'step' => 1,
        ],
        'active_callback' => [
            [
                'setting'  => 'popup_enable',
                'operator' => '==',
                'value'    => true,
            ]
        ],
    ]
);

new \Kirki\Field\Text(
    [
        'settings' => 'popup_text',
        'label'    => esc_html__('Text', 'kirki'),
        'section'  => 'popup_settings',
        'default'  => esc_html__('', 'kirki'),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'popup_enable',
                'operator' => '==',
                'value'    => true,
            ]
        ],
    ]
);

new \Kirki\Field\Text(
    [
        'settings' => 'popup_button_text',
        'label'    => esc_html__('Button Text', 'kirki'),
        'section'  => 'popup_settings',
        'default'  => esc_html__('', 'kirki'),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'popup_enable',
                'operator' => '==',
                'value'    => true,
            ]
        ],
    ]
);

new \Kirki\Field\URL(
    [
        'settings' => 'popup_button_link',
        'label'    => esc_html__('Button Link', 'kirki'),
        'section'  => 'popup_settings',
        'default'  => 'https://',
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'popup_enable',
                'operator' => '==',
                'value'    => true,
            ]
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'popup_text_color',
        'label'       => __('Text Color', 'kirki'),
        'section'     => 'popup_settings',
        'default'     => '#FFFFFF',
        'active_callback' => [
            [
                'setting'  => 'popup_enable',
                'operator' => '==',
                'value'    => true,
            ]
        ],
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--popup-text-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'popup_background_color',
        'label'       => __('Background Color', 'kirki'),
        'section'     => 'popup_settings',
        'default'     => '#171717',
        'active_callback' => [
            [
                'setting'  => 'popup_enable',
                'operator' => '==',
                'value'    => true,
            ]
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--popup-bg-color',
            ],
        ],
        'choices'     => [
            'alpha' => true,
        ],
    ]
);
