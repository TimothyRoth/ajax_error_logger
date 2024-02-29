<?php

declare(strict_types=1);

/**************************************
 * App Configuration
 * *************************************/

const PLUGIN_TEXT_DOMAIN = 'ajax_error_logs';
const PLUGIN_NAME = "Ajax Error Logs";

/**************************************
 * WordPress specific setup
 * *************************************/

load_plugin_textdomain(PLUGIN_TEXT_DOMAIN, FALSE, basename(__DIR__) . '/languages/');
define("PLUGIN_PATH", plugin_dir_path(__FILE__));
define('PLUGIN_URI', plugin_dir_url(__FILE__));

/**************************************
 * API Modules
 * *************************************/

/**
 * API Modules array
 * First key is the module name and its namespace and the value is the holyApi namespace
 * Example: holyApi\{key}\{value}\{key}
 * Consider adding an annotation inside in the app\App.php for IDE autocompletion
 **/

const API_MODULES = [
    'Table' => 'WordPress',
    'Row' => 'WordPress',
    'Column' => 'WordPress',
    'Setting' => 'WordPress',
    'Script' => 'WordPress',
    'Hooks' => 'WordPress',
    'Ajax' => 'WordPress',
    'Cron' => 'WordPress',
    'Url' => 'WordPress',
    'Mail' => 'WordPress',
];
