<?php

declare(strict_types=1);

namespace app\Bootstrap;

use app\App;
use app\Services\Log\Repository\UpdateLogRepositoryService;
use app\Services\Log\Threshold\LogThresholdService;
use app\Settings\Ajax\LogFilter\LogFilter;
use app\Settings\Ajax\DeleteLogs\DeleteLogs;
use app\Settings\Ajax\ExportLogs\ExportLogs;
use app\Settings\Ajax\SendMail\SendMail;

/**
 *
 * Class AjaxBootstrap
 *
 * Class for registering ajax classes
 *
 **/
class AjaxBootstrap
{
    private static array $classes;

    public function __construct()
    {
        self::$classes = [
            UpdateLogRepositoryService::class,
            LogThresholdService::class,
            LogFilter::class,
            DeleteLogs::class,
            ExportLogs::class,
            SendMail::class
        ];

        foreach (self::$classes as $class) {
            App::make($class);
        }
    }
}