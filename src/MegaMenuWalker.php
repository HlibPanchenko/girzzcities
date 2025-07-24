<?php

namespace ESC\Luna;

use \Walker_Nav_Menu;

class MegaMenuWalker extends Walker_Nav_Menu {

    // Открытие подменю
    function start_lvl( &$output, $depth = 0, $args = null ) {
        if ( isset($args->item_spacing) && $args->item_spacing === 'discard' ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = str_repeat($t, $depth);

        $parent_id = $args->menu_id ?? 0; // Получаем ID родительского элемента

        $output .= "{$n}{$indent}<ul class='sub-menu' data-parent-id='{$parent_id}'>{$n}"; // Добавляем data-parent-id
    }

    // Закрытие подменю
    function end_lvl( &$output, $depth = 0, $args = null ) {
        if ( isset($args->item_spacing) && $args->item_spacing === 'discard' ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = str_repeat($t, $depth);

        $output .= "{$indent}</ul>{$n}"; // Закрываем <ul class="sub-menu">
    }

    // Открытие элемента меню
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        if ( isset($args->item_spacing) && $args->item_spacing === 'discard' ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

        // Добавляем data-menu-id для элементов с подменю
        $menu_id = 'menu-item-' . $item->ID;
        if (in_array('menu-item-has-children', $classes)) {
            $class_names .= ' menu-item-has-children';
            $class_names .= " data-menu-id='{$menu_id}'";
        }

        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $output .= "{$indent}<li id='menu-item-{$item->ID}'{$class_names}>";

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )       ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )       ? $item->url        : '';

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= " {$attr}='{$value}'";
            }
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $item_output = "{$args->before}<a{$attributes}>{$args->link_before}{$title}{$args->link_after}</a>{$args->after}";

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    // Закрытие элемента меню
    function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= "</li>\n";
    }
}

function get_submenus_with_taxonomies($menu_items) {
    $submenus = [];

    foreach ($menu_items as $item) {
        if (empty($item->menu_item_parent)) {
            continue; // Пропускаем элементы, которые не являются частью подменю
        }

        $parent_id = $item->menu_item_parent;
        $parent_title = get_the_title($parent_id);

        // Получаем URL и извлекаем таксономию
        $url = parse_url($item->url, PHP_URL_PATH);
        $segments = explode('/', trim($url, '/'));
        $taxonomy = end($segments);

        // Добавляем таксономию в массив
        if (!isset($submenus[$parent_title])) {
            $submenus[$parent_title] = [
                'parent' => $parent_title,
                'taxonomies' => []
            ];
        }

        if (!in_array($taxonomy, $submenus[$parent_title]['taxonomies'])) {
            $submenus[$parent_title]['taxonomies'][] = $taxonomy;
        }
    }

    return $submenus;
}

// Пример использования в `Walker_Nav_Menu`
function generate_menu_data($menu_location) {
    $menu_items = wp_get_nav_menu_items(get_nav_menu_locations()[$menu_location]);

    if (!$menu_items) {
        return [];
    }

    return get_submenus_with_taxonomies($menu_items);
}

// Вывод данных
$menu_data = generate_menu_data('header_menu'); // Укажи нужный location меню
echo '<pre>' . print_r($menu_data, true) . '</pre>';
