<?php
use ESC\Luna\ThemeFunctions;

new \Kirki\Section(
    'pagination_settings',
    [
        'title'       => esc_html__('Pagination Settings', 'kirki'),
        'panel'       => 'theme_settings',
        'priority'    => 160,
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'pagination_bg_color',
        'label'       => __('Pagination Background Color', 'kirki'),
        'section'     => 'pagination_settings',
        'default'     => '#ccc',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--pagination-bg-color',
            ],
            [
                'element'  => ':root',
                'property' => '--pagination-bg-color-rgb',
                'sanitize_callback' => [ThemeFunctions::class, 'hexToRGB']
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'pagination_color',
        'label'       => __('Pagination Color', 'kirki'),
        'section'     => 'pagination_settings',
        'default'     => '#606060',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--pagination-color',
            ],
            [
                'element'  => ':root',
                'property' => '--pagination-color-rgb',
                'sanitize_callback' => [ThemeFunctions::class, 'hexToRGB']
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'pagination_active_color',
        'label'       => __('Pagination Active Color', 'kirki'),
        'section'     => 'pagination_settings',
        'default'     => '#ffffff',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--pagination-active-color',
            ],
            [
                'element'  => ':root',
                'property' => '--pagination-active-color-rgb',
                'sanitize_callback' => [ThemeFunctions::class, 'hexToRGB']
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'pagination_bg_active_color',
        'label'       => __('Pagination Background Active Color', 'kirki'),
        'section'     => 'pagination_settings',
        'default'     => '#ed2b99',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--pagination-bg-active-color',
            ],
            [
                'element'  => ':root',
                'property' => '--pagination-bg-active-color-rgb',
                'sanitize_callback' => [ThemeFunctions::class, 'hexToRGB']
            ],
        ],
    ]
);
