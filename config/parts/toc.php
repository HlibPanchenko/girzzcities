<?php
new \Kirki\Section(
    'toc_settings',
    [
        'title'       => esc_html__('TOC Settings', 'kirki'),
        'panel'       => 'theme_settings',
        'priority'    => 160,
    ]
);


new \Kirki\Field\Text(
    [
        'settings' => 'toc_text',
        'label'    => esc_html__('Toc text', 'kirki'),
        'section'  => 'toc_settings',
        'default'  => esc_html__('Содержание', 'kirki'),
        'priority' => 10,
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'toc_heading_color',
        'label'       => __('Heading Color', 'kirki'),
        'section'     => 'toc_settings',
        'default'     => '#000',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--toc_heading_color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'toc_text_color',
        'label'       => __('Text Color', 'kirki'),
        'section'     => 'toc_settings',
        'default'     => '#000',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--toc_text_color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'toc_bg_color',
        'label'       => __('Background Color', 'kirki'),
        'section'     => 'toc_settings',
        'default'     => '#f5f5f5',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--toc_bg_color',
            ],
        ],
    ]
);
