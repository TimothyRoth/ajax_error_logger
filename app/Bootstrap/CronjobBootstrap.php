<?php

declare(strict_types=1);

namespace app\Bootstrap;

use app\App;
use app\Services\Cron\Mail\MailService;

/**
 *
 * Class CronjobBootstrap
 *
 * Class for registering cronjob classes
 *
 **/
class CronjobBootstrap
{
    private static array $classes;

    public function __construct()
    {
        self::$classes = [
            MailService::class
        ];

        foreach (self::$classes as $class) {
            App::make($class);;
        }
    }
}