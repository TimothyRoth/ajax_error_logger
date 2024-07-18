<?php

namespace HolyApi\Cron;

interface CronInterface
{

    public function register(callable $event, string $schedule_name, int $interval = 2880, string $interval_name = PLUGIN_TEXT_DOMAIN . '_interval'): void;
    public function delete(string $schedule_name): void;
}