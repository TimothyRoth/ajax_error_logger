<?php

declare(strict_types=1);

namespace app;

use holyApi;
use app\Bootstrap\AjaxBootstrap;
use app\Bootstrap\CronjobBootstrap;
use app\Bootstrap\RepositoryBootstrap;
use app\Bootstrap\SettingsBootstrap;
use RuntimeException;

/**
 *
 * Class App
 *
 * Main application class responsible for bootstrapping the application.
 *
 * Adding annotations for IDE autocompletion
 * @method static holyApi\Table\WordPress\Table Table()
 * @method static holyApi\Row\WordPress\Row Row()
 * @method static holyApi\Column\WordPress\Column Column()
 * @method static holyApi\Setting\WordPress\Setting Setting()
 * @method static holyApi\Script\WordPress\Script Script()
 * @method static holyApi\Hooks\WordPress\Hooks Hooks()
 * @method static holyApi\Ajax\WordPress\Ajax Ajax()
 * @method static holyApi\Cron\WordPress\Cron Cron()
 * @method static holyApi\Url\WordPress\Url Url()
 * @method static holyApi\Mail\WordPress\Mail Mail()
 *
 */
class App
{
    private static ?App $instance = null;
    private static array $cache;
    private static array $bootstrap_tasks;
    private static array $api_modules;

    public function __construct()
    {
        /*
         * Establish the bootstrap tasks that need to be executed on application start.
         * */
        self::$bootstrap_tasks = [
            SettingsBootstrap::class,
            AjaxBootstrap::class,
            CronjobBootstrap::class,
            RepositoryBootstrap::class,
        ];

        /*
         * Destructuring the API modules from the API_MODULES Constant and saving it inside an internal array.
         * */

        foreach (API_MODULES as $module_name => $api_namespace) {
            $class = "holyApi\\" . ucfirst($module_name) . "\\" . $api_namespace . "\\{$module_name}";
            self::$api_modules[$module_name] = self::make($class);
        }

    }

    /**
     * Instantiates and returns an instance of a class.
     *
     * @param string $class The class name to instantiate.
     * @return object $cache[$class] || new $class() The instantiated class instance.
     */
    public static function make(string $class): mixed
    {
        /*
         * Instantiate the class if it has not been instantiated before
         * */
        if (!isset(self::$cache[$class])) {
            self::$cache[$class] = new $class();
        }

        return self::$cache[$class];
    }

    /**
     * @throws \Exception
     *
     *  Checking if the array key exists in the API modules array.
     *  IF it does: Iterate through the API modules and returning a callable method
     *  to make the API modules accessible statically throughout the entire application.
     *  Else: Throw a runtime exception.
     *
     *  Example: App::{module_name}()->{method_name}();
     */
    public static function __callStatic(string $name, array $arguments)
    {
        if (array_key_exists($name, self::$api_modules)) {
            return self::$api_modules[$name];
        }

        throw new RuntimeException("Static method {$name} does not exist in " . __CLASS__);
    }

    /**
     *
     * @return self The singleton instance of the App class.
     * Implements the singleton pattern to ensure that only one instance of the class exists.
     * Gives the user the freedom to instantiate the class to use non-static methods, if necessary.
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Bootstrapping the application
     *
     * @return void
     */
    public static function run(): void
    {
        foreach (self::$bootstrap_tasks as $task) {
            self::make($task);
        }
    }

}

