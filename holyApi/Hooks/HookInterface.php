<?php

namespace holyApi\Hooks;

interface HookInterface
{
    public function addFilter($hook, $function, $priority = 10, $accepted_args = 1): void;

    public function addAction($hook, $function, $priority = 10, $accepted_args = 1): void;

    public function executeOnPluginActivation(string $plugin_file, array $method): void;

}