<?php

namespace ESC\Luna\Modules;

class ModelsViewModule
{
    public static function registerHooks(): void
    {
        add_action('wp_ajax_addviews', [__CLASS__, 'addView']);
        add_action('wp_ajax_nopriv_addviews', [__CLASS__, 'addView']);
        add_filter('manage_edit-models_columns', [__CLASS__, 'viewsAdminColumn']);
        add_action('manage_models_posts_custom_column', [__CLASS__, 'populateViewsColumn'], 10, 2);
        add_filter('manage_edit-models_sortable_columns', [__CLASS__, 'viewsAdminSortable']);
        add_action('pre_get_posts', [__CLASS__, 'viewsAdminOrderBy']);
    }

    public static function addView(): void
    {
        $post_id = $_POST['post_id'];

        $views = get_field('views', $post_id);
        $views++;

        update_field('views', $views, $post_id);
    }

    public static function viewsAdminColumn($columns): array
    {
        $columns['views'] = 'Просмотры';
        return $columns;
    }

    public static function populateViewsColumn($column, $post_id): void
    {
        if ($column === 'views') {
            $views = get_field('views', $post_id) ? get_field('views', $post_id) : 0;
            echo $views;
        }
    }

    public static function viewsAdminSortable($columns): array
    {
        $columns['views'] = 'views';
        return $columns;
    }

    public static function viewsAdminOrderBy($query): void
    {
        if (!is_admin() || !$query->is_main_query()) {
            return;
        }

        $orderby = $query->get('orderby');

        if ($orderby === 'views') {
            $query->set('meta_key', 'views');
            $query->set('orderby', 'meta_value_num');
        }
    }
}