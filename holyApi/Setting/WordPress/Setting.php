<?php

namespace holyApi\Setting\WordPress;

use holyApi\Setting\SettingInterface;

class Setting implements SettingInterface
{

    public function create(string $setting_name, mixed $value = '', bool|string $autoload = 'yes'): bool
    {
        return add_option($setting_name, $value, '', $autoload);
    }

    public function read(string $setting_name, mixed $default_value = false): mixed
    {
        return get_option($setting_name, $default_value);
    }

    public function update(string $setting_name, mixed $value, bool|string $autoload = 'yes'): bool
    {
        return update_option($setting_name, $value, $autoload);
    }

    public function delete(string $setting_name): bool
    {
        return delete_option($setting_name);
    }

    public function updateSettings(array $fields, bool $auto_hook = false): void
    {
        if ($auto_hook) {
            add_action('init', function () use ($fields) {
                foreach ($fields as $setting) {
                    if (isset($_POST[$setting])) {
                        $this->update($setting, $_POST[$setting]);
                    }
                }
            });
            return;
        }

        foreach ($fields as $setting) {
            if (isset($_POST[$setting])) {
                $this->update($setting, $_POST[$setting]);
            }
        }

    }

    public function createMenuPage(string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function, bool $auto_hook = false, string $icon_url = 'dashicons-admin-generic', int $position = 6): void
    {
        if ($auto_hook) {
            add_action('admin_menu', function () use ($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position) {
                add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
            });
            return;
        }

        add_menu_page(
            __($page_title, PLUGIN_TEXT_DOMAIN),
            __($menu_title, PLUGIN_TEXT_DOMAIN),
            $capability,
            $menu_slug,
            $function,
            $icon_url,
            $position
        );
    }

}