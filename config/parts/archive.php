<?php
new \Kirki\Section(
    'archive_settings',
    [
        'title'       => esc_html__('Archive Settings', 'kirki'),
        'description' => esc_html__('My Section Description.', 'kirki'),
        'panel'       => 'theme_settings',
        'priority'    => 160,
    ]
);

$taxonomies = ['options', 'area', 'metro', 'services'];

new \Kirki\Field\Checkbox_Toggle(
    [
        'settings'    => 'archive_services_filter_hide',
        'label'       => esc_html__('Services Filter Hide', 'kirki'),
        'section'     => 'archive_settings',
        'default'     => '0',
        'priority'    => 10,
    ]
);

new \Kirki\Field\Checkbox_Toggle(
    [
        'settings'    => 'archive_area_filter_hide',
        'label'       => esc_html__('Area Filter Hide', 'kirki'),
        'section'     => 'archive_settings',
        'default'     => '0',
        'priority'    => 10,
    ]
);

new \Kirki\Field\Checkbox_Toggle(
    [
        'settings'    => 'archive_metro_filter_hide',
        'label'       => esc_html__('Metro Filter Hide', 'kirki'),
        'section'     => 'archive_settings',
        'default'     => '0',
        'priority'    => 10,
    ]
);

new \Kirki\Field\Checkbox_Toggle(
    [
        'settings'    => 'archive_price_filter_hide',
        'label'       => esc_html__('Price Filter Hide', 'kirki'),
        'section'     => 'archive_settings',
        'default'     => '0',
        'priority'    => 10,
    ]
);

new \Kirki\Field\Checkbox_Toggle(
    [
        'settings'    => 'archive_params_filter_hide',
        'label'       => esc_html__('Parameters Filter Hide', 'kirki'),
        'section'     => 'archive_settings',
        'default'     => '0',
        'priority'    => 10,
    ]
);

new \Kirki\Field\Checkbox_Toggle(
    [
        'settings'    => 'archive_services_parent_terms',
        'label'       => esc_html__('Show parent terms', 'kirki'),
        'section'     => 'archive_settings',
        'default'     => '0',
        'priority'    => 10,
    ]
);