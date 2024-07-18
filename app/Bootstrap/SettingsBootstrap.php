<?php

declare(strict_types=1);

namespace app\Bootstrap;

use app\App;
use app\Settings\AppSettings;

/**
 *
 * Class SettingsBootstrap
 *
 * Class for registering setting classes
 *
 **/
class SettingsBootstrap
{

    private static array $classes;

    public function __construct()
    {
        self::$classes = [
            AppSettings::class
        ];

        App::Hooks()->addAction('admin_enqueue_scripts', [$this, 'registerPluginScripts']);
        App::Hooks()->addAction('wp_enqueue_scripts', [$this, 'registerPluginScripts']);

        foreach (self::$classes as $class) {
            App::make($class);
        }
    }

    public function registerPluginScripts(): void
    {
        App::Script()->add('user-bundle', PLUGIN_URI . '/dist/main.min.js');
        App::Script()->patch('user-bundle', 'ajax', ['url' => App::Url()->getAdminBasepath('admin-ajax.php')]);
        App::Script()->addStylesheet('ajax-error-logs-admin-css', PLUGIN_URI . '/dist/main.min.css', [], '0.1', 'all');
    }
}
