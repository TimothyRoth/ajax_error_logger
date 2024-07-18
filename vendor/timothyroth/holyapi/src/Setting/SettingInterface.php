<?php

namespace HolyApi\Setting;

interface SettingInterface
{
    public function create(string $setting_name, mixed $value = '', string|bool $autoload = 'yes'): bool;

    public function read(string $setting_name, mixed $default_value = false): mixed;

    public function update(string $setting_name, mixed $value, string|bool $autoload = 'yes'): bool;

    public function delete(string $setting_name): bool;

    public function createMenuPage(string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function, bool $auto_hook, string $icon_url = 'dashicons-admin-generic', int $position = 6): void;

    public function updateSettings(array $fields, bool $auto_hook = false): void;

}