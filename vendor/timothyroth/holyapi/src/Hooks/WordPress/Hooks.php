<?php

namespace HolyApi\Hooks\WordPress;

use HolyApi\Hooks\HookInterface;

class Hooks implements HookInterface
{

    public function addFilter($hook, $function, $priority = 10, $accepted_args = 1): void
    {
        add_filter($hook, $function, $priority, $accepted_args);
    }

    public function addAction($hook, $function, $priority = 10, $accepted_args = 1): void
    {
        add_action($hook, $function, $priority, $accepted_args);
    }

    public function executeOnPluginActivation(string $plugin_file, array|string|callable $executable): void
    {
        if (is_array($executable)) {
            register_activation_hook($plugin_file, [$executable[0], $executable[1]]);
        }

        if (is_callable($executable)) {
            register_activation_hook($plugin_file, function () use ($executable) {
                $executable();
            });
        }

        if (is_string($executable)) {
            register_activation_hook($plugin_file, $executable);
        }
    }


}