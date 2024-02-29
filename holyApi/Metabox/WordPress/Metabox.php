<?php

namespace holyApi\Metabox\WordPress;

use holyApi\Metabox\MetaboxInterface;

class Metabox implements MetaboxInterface
{
    public function create(string $name, callable $callback, string|array $screen = null, $auto_hook = false, string $context = 'advanced', string $priority = 'default', array $callback_args = null): void
    {
        if ($auto_hook) {
            add_action('add_meta_boxes', function () use ($name, $callback, $screen, $context, $priority, $callback_args) {
                add_meta_box($name, $name, $callback, $screen, $context, $priority, $callback_args);
            });
            return;
        }

        add_meta_box($name, $name, $callback, $screen, $context, $priority, $callback_args);
    }

    public function updateFields(array $fields, bool $auto_hook = false): void
    {
        if ($auto_hook) {
            add_action('save_post', function () use ($fields) {
                $this->saveFields($fields);
            });

            return;
        }

        $this->saveFields($fields);
    }

    public function delete(string $id, string|array $screen, $auto_hook = false, string $context = 'advanced'): void
    {
        if ($auto_hook) {
            add_action('add_meta_boxes', function () use ($id, $screen, $context) {
                remove_meta_box($id, $screen, $context);
            });
            return;
        }
        remove_meta_box($id, $screen, $context);
    }

    private function saveFields($fields): void
    {
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta(get_the_id(), $field, $_POST[$field]);
            }
        }
    }

}