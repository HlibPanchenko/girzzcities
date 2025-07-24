<?php

namespace ESC\Luna;

use \Walker_Nav_Menu;

class DefaultMenuWalker extends Walker_Nav_Menu {

    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0) {
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $class_names = join(' ', array_filter($classes));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id_attr = ' id="menu-item-' . esc_attr($item->ID) . '"';

        $output .= '<li' . $id_attr . $class_names . '>';

        $attributes  = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target)     . '"' : '';
        $attributes .= !empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn)        . '"' : '';
        $attributes .= !empty($item->url)        ? ' href="'   . esc_attr($item->url)        . '"' : '';

        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

        $item_output  = $args->before ?? '';
        $item_output .= '<div class="menu-link-wrapper">';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before ?? '';
        $item_output .= $title;
        $item_output .= $args->link_after ?? '';
        $item_output .= '</a>';

        if (in_array('menu-item-has-children', $classes)) {
            $item_output .= ThemeFunctions::getInlineSvg('arrowdown');
        }

        $item_output .= '</div>';
        $item_output .= $args->after ?? '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}
