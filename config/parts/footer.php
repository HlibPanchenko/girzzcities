<?php
new \Kirki\Section(
    'footer_settings',
    [
        'title'       => esc_html__('Footer Settings', 'kirki'),
        'description' => esc_html__('My Section Description.', 'kirki'),
        'panel'       => 'theme_settings',
        'priority'    => 160,
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'footer_background_color',
        'label'       => __('Background Color', 'kirki'),
        'section'     => 'footer_settings',
        'default'     => '#141414',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--footer-bg-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'footer_text_color',
        'label'       => __('Text Color', 'kirki'),
        'section'     => 'footer_settings',
        'default'     => '#ffffff',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--footer-text-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'footer_link_color',
        'label'       => __('Link Color', 'kirki'),
        'section'     => 'footer_settings',
        'default'     => '#ffffff',
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--footer-link-color',
            ],
        ],
        'choices'     => [
            'alpha' => true,
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'footer_hover_link_color',
        'label'       => __('Hover Link Color', 'kirki'),
        'section'     => 'footer_settings',
        'default'     => '#E20F0F',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--footer-hover-link-color',
            ],
        ],
    ]
);
