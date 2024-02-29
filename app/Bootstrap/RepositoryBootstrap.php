<?php

declare(strict_types=1);

namespace app\Bootstrap;

use app\App;
use app\Database\Tables\LogTable;

/**
 *
 * Class RepositoryBootstrap
 *
 * Class for registering repositories
 *
 **/
class RepositoryBootstrap
{
    private static array $classes;

    public function __construct()
    {
        self::$classes = [
            LogTable::class
        ];

        foreach (self::$classes as $class) {
            App::make($class);
        }
    }
}