<?php
use ESC\Luna\ThemeFunctions;

new \Kirki\Section(
    'contacts_settings',
    [
        'title'       => esc_html__('Contacts Settings', 'kirki'),
        'description' => esc_html__('My Section Description.', 'kirki'),
        'panel'       => 'theme_settings',
        'priority'    => 160,
    ]
);

new \Kirki\Field\Checkbox_Toggle(
    [
        'settings'    => 'contacts_phone_enable',
        'label'       => esc_html__('Enable Phone Number', 'kirki'),
        'section'     => 'contacts_settings',
        'default'     => '0',
        'priority'    => 10,
    ]
);

new \Kirki\Field\Text(
    [
        'settings' => 'contacts_phone',
        'label'    => esc_html__('Phone Number', 'kirki'),
        'section'  => 'contacts_settings',
        'default'  => esc_html__('', 'kirki'),
        'priority' => 10,
    ]
);

new \Kirki\Field\Checkbox_Toggle(
    [
        'settings'    => 'contacts_telegram_enable',
        'label'       => esc_html__('Enable Telegram', 'kirki'),
        'section'     => 'contacts_settings',
        'default'     => '0',
        'priority'    => 10,
    ]
);

new \Kirki\Field\URL(
    [
        'settings' => 'contacts_telegram',
        'label'    => esc_html__('Telegram Link', 'kirki'),
        'section'  => 'contacts_settings',
        'default'  => 'https://t.me/',
        'priority' => 10,
    ]
);

new \Kirki\Field\Checkbox_Toggle(
    [
        'settings'    => 'contacts_whatsapp_enable',
        'label'       => esc_html__('Enable WhatsApp', 'kirki'),
        'section'     => 'contacts_settings',
        'default'     => '0',
        'priority'    => 10,
    ]
);

new \Kirki\Field\URL(
    [
        'settings' => 'contacts_whatsapp',
        'label'    => esc_html__('WhatsApp Link', 'kirki'),
        'section'  => 'contacts_settings',
        'default'  => 'https://wa.me/',
        'priority' => 10,
    ]
);

new \Kirki\Field\Text(
    [
        'settings' => 'contacts_hint',
        'label'    => esc_html__('Hint Text', 'kirki'),
        'section'  => 'contacts_settings',
        'default'  => esc_html__('или Напишите нам в удобный для Вас мессенджер', 'kirki'),
        'priority' => 10,
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'header_phone_color',
        'label'       => __('Phone Background Color', 'kirki'),
        'section'     => 'contacts_settings',
        'default'     => '#dd4f4f',
        'tab'      => 'colors',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--header-phone-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'header_phone_text_color',
        'label'       => __('Phone Text Color', 'kirki'),
        'section'     => 'contacts_settings',
        'default'     => '#ffffff',
        'tab'      => 'colors',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--header-phone-text-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'header_tg_color',
        'label'       => __('Telegram Color', 'kirki'),
        'section'     => 'contacts_settings',
        'default'     => '#6495ed',
        'tab'      => 'colors',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--header-tg-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'header_tg_text_color',
        'label'       => __('Telegram Text Color', 'kirki'),
        'section'     => 'contacts_settings',
        'default'     => '#ffffff',
        'tab'      => 'colors',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--header-tg-text-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'header_wa_color',
        'label'       => __('Whatsapp Color', 'kirki'),
        'section'     => 'contacts_settings',
        'default'     => '#57e85e',
        'tab'      => 'colors',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--header-wa-color',
            ],
        ],
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'header_wa_text_color',
        'label'       => __('Whatsapp Text Color', 'kirki'),
        'section'     => 'contacts_settings',
        'default'     => '#ffffff',
        'tab'      => 'colors',
        'choices'     => [
            'alpha' => true,
        ],
        'output'   => [
            [
                'element'  => ':root',
                'property' => '--header-wa-text-color',
            ],
        ],
    ]
);