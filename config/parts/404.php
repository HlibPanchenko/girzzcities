<?php
new \Kirki\Section(
    'page_404_settings',
    [
        'title'       => esc_html__('404 Settings', 'kirki'),
        'panel'       => 'theme_settings',
        'priority'    => 160,
    ]
);


new \Kirki\Field\Text(
    [
        'settings' => 'page_404_text',
        'label'    => esc_html__('Text 404', 'kirki'),
        'section'  => 'page_404_settings',
        'default'  => esc_html__('Ой... Похоже, этой страницы нет!', 'kirki'),
        'priority' => 10,
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'page_404_text_color',
        'label'       => __('Text Color', 'kirki'),
        'section'     => 'page_404_settings',
        'default'     => '#000',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--page-404-text-color',
            ],
        ],
    ]
);

new \Kirki\Field\Image(
    [
        'settings'    => 'page_404_image',
        'label'       => esc_html__('Image for 404', 'kirki'),
        'section'     => 'page_404_settings',
        'default'     => '',
        'choices'     => [
            'save_as' => 'id',
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'page_404_code_color',
        'label'       => __('Code Color', 'kirki'),
        'section'     => 'page_404_settings',
        'default'     => '#007bff',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--page-404-code-color',
            ],
        ],
        'active_callback' => function () {
            $image_id = get_theme_mod('page_404_image', '');
            return empty($image_id);
        },
    ]
);