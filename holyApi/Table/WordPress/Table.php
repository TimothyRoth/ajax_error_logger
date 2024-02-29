<?php

namespace holyApi\Table\WordPress;

use holyApi\Table\TableInterface;
use WP_Query;

class Table implements TableInterface
{


    public function create(string $table_name, $auto_hook = false, bool $show_in_menu = true, $public = false, $has_archive = false, string $menu_icon = "dashicons-admin-post", array $args = null): mixed
    {
        $labels = [
            'name' => _x($table_name, 'post type general name', ''),
        ];

        $default_args = [
            'label' => __($table_name, PLUGIN_TEXT_DOMAIN),
            'labels' => $labels,
            'hierarchical' => false,
            'public' => $public,
            'show_ui' => $show_in_menu,
            'show_in_menu' => $show_in_menu,
            'show_in_admin_bar' => $show_in_menu,
            'show_in_nav_menus' => $show_in_menu,
            'menu_icon' => $menu_icon,
            'can_export' => true,
            'publicly_queryable' => $public,
            'has_archive' => $has_archive,
            'exclude_from_search' => !$public,
            'capability_type' => 'post',
            '_builtin' => false,
            'query_var' => false,
        ];

        if ($args) {
            $default_args = array_merge($default_args, $args);
        }

        if ($auto_hook) {
            return add_action('init', function () use ($table_name, $default_args) {
                register_post_type($table_name, $default_args);
            });
        }

        return register_post_type($table_name, $default_args);
    }

    public function drop(string $table_name, $auto_hook = false): mixed
    {
        if ($auto_hook) {
            return add_action('init', function () use ($table_name) {
                unregister_post_type($table_name);
            });
        }

        return unregister_post_type($table_name);
    }

    public function query(array $query_args): mixed
    {
        return new WP_Query($query_args);
    }
}