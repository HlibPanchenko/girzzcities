<?php
use ESC\Luna\ThemeFunctions;

new \Kirki\Section(
    'cities_settings',
    [
        'title'       => esc_html__('Cities Switcher', 'kirki'),
        'description' => esc_html__('Cities Switcher Description.', 'kirki'),
        'panel'       => 'theme_settings',
        'priority'    => 160,
    ]
);

new \Kirki\Field\Checkbox_Toggle(
    [
        'settings'    => 'switcher_enable',
        'label'       => esc_html__('Switcher Enable', 'kirki'),
        'section'     => 'cities_settings',
        'default'     => '0',
        'priority'    => 10,
    ]
);

new \Kirki\Field\Text(
    [
        'settings' => 'switcher_text',
        'label'    => esc_html__('Switcher Text', 'kirki'),
        'section'  => 'cities_settings',
        'default'  => esc_html__('', 'kirki'),
        'priority' => 10,
    ]
);


new \Kirki\Field\Color(
    [
        'settings'    => 'switcher_color',
        'label'       => __('Switcher Color', 'kirki'),
        'section'     => 'cities_settings',
        'default'     => '#000000',
        'tab'      => 'colors',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--switcher-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'switcher_bg_color',
        'label'       => __('Switcher Background Color', 'kirki'),
        'section'     => 'cities_settings',
        'default'     => '#ffffff',
        'tab'      => 'colors',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--switcher-bg-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'switcher_hover_bg_color',
        'label'       => __('Switcher Hover Background Color', 'kirki'),
        'section'     => 'cities_settings',
        'default'     => '#000000',
        'tab'      => 'colors',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--switcher-hover-bg-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'switcher_hover_color',
        'label'       => __('Switcher Hover Color', 'kirki'),
        'section'     => 'cities_settings',
        'default'     => '#ffffff',
        'tab'      => 'colors',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--switcher-hover-color',
            ],
        ],
    ]
);

