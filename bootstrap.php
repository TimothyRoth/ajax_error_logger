<?php

/**
 * Plugin Name: Error Logs for Ajax Requests
 * Plugin URI: https://timothy-roth.de
 * Description: This plugin provides an email error_logs and file export service for ajax error logs.
 * Version: 1.0.0
 * Author: Timothy Roth
 * Author URI: https://timothy-roth.de
 * License: GPL2
 * Text Domain: ajax_error_logs
 * Domain Path: /languages
 */

/**************************************
 * PLUGIN BASENAME (WordPress Specific)
 * *************************************/

define('PLUGIN_BASENAME', plugin_basename(__FILE__));

/**************************************
 * Configuration
 * *************************************/

require_once 'plugin-config.php';

/**************************************
 * Autoload
 * *************************************/

require_once __DIR__ . '/vendor/autoload.php';

/**************************************
 * Bootstrap
 * *************************************/

use app\App;

App::getInstance()::run();