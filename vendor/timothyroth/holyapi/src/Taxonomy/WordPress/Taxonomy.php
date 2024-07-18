<?php

namespace HolyApi\Taxonomy\WordPress;

use HolyApi\Taxonomy\TaxonomyInterface;

class Taxonomy implements TaxonomyInterface
{
    public function create(string $taxonomy_name, string|array $table_name, bool $auto_hook = false, array $args = null): void
    {
        $labels = array(
            'name' => _x($taxonomy_name, 'taxonomy general name', PLUGIN_TEXT_DOMAIN),
            'singular_name' => _x($taxonomy_name, 'taxonomy singular name', PLUGIN_TEXT_DOMAIN),
            'search_items' => __('Search in ' . $taxonomy_name, PLUGIN_TEXT_DOMAIN),
            'all_items' => __('All ' . $taxonomy_name, PLUGIN_TEXT_DOMAIN),
            'parent_item' => __('Superior ' . $taxonomy_name, PLUGIN_TEXT_DOMAIN),
            'parent_item_colon' => __('Superior ' . $taxonomy_name . ':', PLUGIN_TEXT_DOMAIN),
            'edit_item' => __('Edit ' . $taxonomy_name, PLUGIN_TEXT_DOMAIN),
            'update_item' => __('Save' . $taxonomy_name, PLUGIN_TEXT_DOMAIN),
            'add_new_item' => __('New ' . $taxonomy_name, PLUGIN_TEXT_DOMAIN),
            'new_item_name' => __('Name of ' . $taxonomy_name, PLUGIN_TEXT_DOMAIN),
            'menu_name' => __($taxonomy_name, PLUGIN_TEXT_DOMAIN),
        );

        $default_args = array(
            'labels' => $labels,
            'public' => true,
            'hierarchical' => true,
            'query_var' => true,
            'rewrite' => array('slug' => $taxonomy_name),
        );

        if ($args) {
            $default_args = array_merge($default_args, $args);
        }

        if (!$auto_hook) {
            register_taxonomy($taxonomy_name, lcfirst($table_name), $default_args);
        }

        add_action('init', function () use ($taxonomy_name, $table_name, $default_args, &$return_value) {
            $return_value = register_taxonomy($taxonomy_name, lcfirst($table_name), $default_args);
        });

    }

    public
    function read(string $taxonomy_name): ?object
    {
        $taxonomy_object = get_taxonomy($taxonomy_name);
        return $taxonomy_object ? (object)$taxonomy_object : null;
    }

    public function update(string $taxonomy_name, string $table_name, array $args = []): bool
    {
        $old_taxonomy = $this->read($taxonomy_name);

        if ($old_taxonomy) {
            $args = array_merge((array)$old_taxonomy, $args);
            $this->delete($taxonomy_name);
            $this->create($taxonomy_name, $table_name, 'false', $args);
            return true;
        }

        return false;
    }

    public
    function delete(string $taxonomy_name, bool $auto_hook = false): bool
    {
        if ($auto_hook) {
            return add_action('init', function () use ($taxonomy_name) {
                unregister_taxonomy($taxonomy_name);
            });
        }

        if (taxonomy_exists($taxonomy_name)) {
            return unregister_taxonomy($taxonomy_name);
        }
        return false;
    }
}