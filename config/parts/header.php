<?php

use ESC\Luna\ThemeFunctions;

new \Kirki\Section(
    'header_settings',
    [
        'title'       => esc_html__('Header Settings', 'kirki'),
        'description' => esc_html__('My Section Description.', 'kirki'),
        'panel'       => 'theme_settings',
        'tabs'  => [
            'general' => [
                'label' => esc_html__( 'General', 'kirki' ),
            ],
            'menu'  => [
                'label' => esc_html__( 'Menu', 'kirki' ),
            ],
            'burger'  => [
                'label' => esc_html__( 'Burger', 'kirki' ),
            ],
            'banner'  => [
                'label' => esc_html__( 'Banner', 'kirki' ),
            ],
        ],
        'priority'    => 160,
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'header_background_color',
        'label'       => __('Background Color', 'kirki'),
        'section'     => 'header_settings',
        'default'     => '#171717',
        'tab'      => 'general',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--header-bg-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'header_secondary_color',
        'label'       => __('Secondary Color', 'kirki'),
        'section'     => 'header_settings',
        'default'     => '#0000000d',
        'tab'      => 'general',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--header-secondary-color',
            ],
        ],
    ]
);

new \Kirki\Field\Checkbox_Toggle(
    [
        'settings'    => 'header_site_name_enable',
        'label'       => esc_html__('Site Name Enable', 'kirki'),
        'section'     => 'header_settings',
        'tab'      => 'general',
        'default'     => '0',
        'priority'    => 10,
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'header_site_name_color',
        'label'       => __('Site Name Color', 'kirki'),
        'section'     => 'header_settings',
        'default'     => '#ffffff',
        'tab'      => 'general',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--header-site-name-color',
            ],
        ],
    ]
);

new \Kirki\Field\Dimension(
    [
        'settings'    => 'header_logo_width',
        'label'       => esc_html__( 'Logo Width', 'kirki' ),
        'section'     => 'header_settings',
        'tab'          => 'general',
        'default'      => [
            'desktop' => '60px',
            'tablet'  => '50px',
            'mobile'  => '40px',
        ],
        'choices'      => [
            'accept_unitless' => true,
        ],
        'responsive'   => true,
        'output'       => [
            [
                'element'     => ':root',
                'property'    => '--header-logo-width',
                'media_query' => [
                    'desktop' => '@media (min-width: 1024px)',
                    'tablet'  => '@media (min-width: 601px) and (max-width: 1023px)',
                    'mobile'  => '@media (max-width: 600px)',
                ],
            ],
        ],
    ]
);


new \Kirki\Field\Color(
    [
        'settings'    => 'header_link_color',
        'label'       => __('Link Color', 'pt-luna'),
        'section'     => 'header_settings',
        'default'     => '#ffffff',
        'tab'      => 'menu',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--header-link-color',
            ],
            [
                'element'  => ':root',
                'property' => '--header-link-color-rgb',
                'sanitize_callback' => [ThemeFunctions::class, 'hexToRGB']
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'header_link_hover_color',
        'label'       => __('Link Hover Color', 'pt-luna'),
        'section'     => 'header_settings',
        'default'     => '#8224e3',
        'tab'      => 'menu',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--header-link-hover-color',
            ]
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'header_link_active_color',
        'label'       => __('Link Active Color', 'pt-luna'),
        'section'     => 'header_settings',
        'tab'      => 'menu',
        'default'     => '#8224e3',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--header-link-active-color',
            ],
            [
                'element'  => ':root',
                'property' => '--header-link-active-color-rgb',
                'sanitize_callback' => [ThemeFunctions::class, 'hexToRGB']
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'header_burger_color',
        'label'       => __('Burger Color', 'pt-luna'),
        'section'     => 'header_settings',
        'tab'      => 'burger',
        'default'     => '#8224e3',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--header-burger-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'header_burger_bg_color',
        'label'       => __('Burger Background Color', 'pt-luna'),
        'section'     => 'header_settings',
        'tab'      => 'burger',
        'default'     => '#8224e3',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--header-burger-bg-color',
            ],
        ],
    ]
);

new \Kirki\Field\Dimension(
    [
        'settings'    => 'header_burger_border_radius',
        'label'       => esc_html__( 'Burger Border Radius', 'pt-luna' ),
        'section'     => 'header_settings',
        'tab'      => 'burger',
        'default'     => '50%',
        'choices'     => [
            'accept_unitless' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--header-burger-border-radius',
            ],
        ],
    ]
);

new \Kirki\Field\Radio_Buttonset(
    [
        'settings'    => 'header_banner_show',
        'label'       => esc_html__( 'Show header banner', 'pt-luna' ),
        'section'     => 'header_settings',
        'tab'      => 'banner',
        'default'     => 'show',
        'priority'    => 10,
        'choices'     => [
            'show'   => esc_html__( 'Show', 'kirki' ),
            'hide' => esc_html__( 'Hide', 'kirki' ),
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'header_banner_bg_color',
        'label'       => __('Banner Background Color', 'pt-luna'),
        'section'     => 'header_settings',
        'tab'      => 'banner',
        'default'     => '#ff0000',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--header-banner-bg-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'header_banner_color',
        'label'       => __('Banner Text Color', 'pt-luna'),
        'section'     => 'header_settings',
        'tab'      => 'banner',
        'default'     => '#ffffff',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--header-banner-color',
            ],
        ],
    ]
);

new \Kirki\Field\Text(
    [
        'settings' => 'header_tel_text',
        'label'    => esc_html__( 'Telephone text', 'pt-luna' ),
        'section'  => 'header_settings',
        'tab'      => 'banner',
    ]
);

new \Kirki\Field\Text(
    [
        'settings' => 'header_tel_text--mobile',
        'label'    => esc_html__( 'Telephone text mobile', 'pt-luna' ),
        'section'  => 'header_settings',
        'tab'      => 'banner',
    ]
);

new \Kirki\Field\Text(
    [
        'settings' => 'header_telegram_text',
        'label'    => esc_html__( 'Telegram text', 'pt-luna' ),
        'section'  => 'header_settings',
        'tab'      => 'banner',
    ]
);

new \Kirki\Field\Text(
    [
        'settings' => 'header_telegram_text--mobile',
        'label'    => esc_html__( 'Telegram text mobile', 'pt-luna' ),
        'section'  => 'header_settings',
        'tab'      => 'banner',
    ]
);

new \Kirki\Field\Text(
    [
        'settings' => 'header_whatsapp_text',
        'label'    => esc_html__( 'Whatsapp text', 'pt-luna' ),
        'section'  => 'header_settings',
        'tab'      => 'banner',
    ]
);

new \Kirki\Field\Text(
    [
        'settings' => 'header_whatsapp_text--mobile',
        'label'    => esc_html__( 'Whatsapp text mobile', 'pt-luna' ),
        'section'  => 'header_settings',
        'tab'      => 'banner',
    ]
);
