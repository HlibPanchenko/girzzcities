<?php
use ESC\Luna\ThemeFunctions;

new \Kirki\Section(
    'filter_settings',
    [
        'title'       => esc_html__('Filter Settings', 'kirki'),
        'panel'       => 'theme_settings',
        'priority'    => 160,
        'tabs'  => [
            'general' => [
                'label' => esc_html__( 'General', 'kirki' ),
            ],
            'tabs' => [
                'label' => esc_html__( 'Tabs', 'kirki' ),
            ],
            'search'  => [
                'label' => esc_html__( 'Search', 'kirki' ),
            ],

        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'filter_bg_color',
        'label'       => __('Background Color', 'kirki'),
        'section'     => 'filter_settings',
        'default'     => '#fff',
        'tab'         => 'general',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--filter-bg-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'filter_text_color',
        'label'       => __('Filter Text Color', 'kirki'),
        'section'     => 'filter_settings',
        'default'     => '#000',
        'tab'         => 'general',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--filter-text-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'filter_input_color',
        'label'       => __('Input Text Color', 'kirki'),
        'section'     => 'filter_settings',
        'default'     => '#000',
        'tab'         => 'general',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--filter_input_color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'filter_accent_color',
        'label'       => __('Accent Color', 'kirki'),
        'section'     => 'filter_settings',
        'default'     => '#f028de',
        'tab'         => 'general',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--filter-accent-color',
            ],
            [
                'element'  => ':root',
                'property' => '--filter-accent-color-rgb',
                'sanitize_callback' => [ThemeFunctions::class, 'hexToRGB']
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'filter_secondary_color',
        'label'       => __('Secondary Color', 'kirki'),
        'section'     => 'filter_settings',
        'default'     => '#f5f5f5',
        'tab'         => 'general',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--filter-secondary-color',
            ],
            [
                'element'  => ':root',
                'property' => '--filter-secondary-color-rgb',
                'sanitize_callback' => [ThemeFunctions::class, 'hexToRGB']
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'filter_tabs_color',
        'label'       => __('Tabs Color', 'kirki'),
        'section'     => 'filter_settings',
        'default'     => '#252525',
        'tab'         => 'tabs',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--filter-tabs-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'filter_tabs_bg_color',
        'label'       => __('Tabs Background Color', 'kirki'),
        'section'     => 'filter_settings',
        'default'     => '#f5f5f5',
        'tab'         => 'tabs',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--filter-tabs-bg-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'filter_tabs_active_color',
        'label'       => __('Tabs Active Color', 'kirki'),
        'section'     => 'filter_settings',
        'default'     => '#fff',
        'tab'         => 'tabs',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--filter-tabs-active-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'filter_tabs_active_bg_color',
        'label'       => __('Tabs Active Background Color', 'kirki'),
        'section'     => 'filter_settings',
        'default'     => '#252525',
        'tab'         => 'tabs',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--filter-tabs-active-bg-color',
            ],
        ],
    ]
);

new \Kirki\Field\Radio_Buttonset(
    [
        'settings'    => 'radio_buttonset_setting',
        'label'       => __('Show first Tab', 'kirki'),
        'section'     => 'section_id',
        'default'     => 'no',
        'tab'         => 'tabs',
        'priority'    => 10,
        'choices'     => [
            'yes'   => esc_html__( 'Show', 'kirki' ),
            'no' => esc_html__( 'Hide', 'kirki' ),
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'filter_search_bg_color',
        'label'       => __('Tabs Search Background Color', 'kirki'),
        'section'     => 'filter_settings',
        'default'     => '#fff',
        'tab'         => 'search',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--filter-search-bg-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'filter_search_border_color',
        'label'       => __('Tabs Search Border Color', 'kirki'),
        'section'     => 'filter_settings',
        'default'     => '#8224e3',
        'tab'         => 'search',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--filter-search-border-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'filter_search_color',
        'label'       => __('Tabs Search Color', 'kirki'),
        'section'     => 'filter_settings',
        'default'     => '#202124',
        'tab'         => 'search',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--filter-search-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'filter_search_placeholder_color',
        'label'       => __('Tabs Search Placeholder Color', 'kirki'),
        'section'     => 'filter_settings',
        'default'     => '#bebfbf',
        'tab'         => 'search',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--filter-search-placeholder-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'filter_search_icon_bg_color',
        'label'       => __('Search Icon Background Color', 'kirki'),
        'section'     => 'filter_settings',
        'default'     => '#ffffff',
        'tab'         => 'search',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--filter_search_icon_bg_color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'filter_search_icon_color',
        'label'       => __('Search Icon Color', 'kirki'),
        'section'     => 'filter_settings',
        'default'     => '#000000',
        'tab'         => 'search',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--filter_search_icon_color',
            ],
        ],
    ]
);
