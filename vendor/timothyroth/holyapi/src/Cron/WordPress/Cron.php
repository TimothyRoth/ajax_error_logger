<?php

namespace HolyApi\Cron\WordPress;

use HolyApi\Cron\CronInterface;

class Cron implements CronInterface
{

    public function register(callable $event, string $schedule_name, int $interval = 2880, string $interval_name = PLUGIN_TEXT_DOMAIN . '_interval'): void
    {

        add_filter('cron_schedules', function ($schedules) use ($interval_name, $interval): array {

            $schedules[$interval_name] = [
                'interval' => $interval,
                'display' => __($interval_name, PLUGIN_TEXT_DOMAIN)
            ];

            return $schedules;
        });

        $next_scheduled = wp_next_scheduled($schedule_name);

        if ($next_scheduled) {
            $schedules = wp_get_schedules();
            $current_interval = $schedules[$interval_name]['interval'];

            $interval_changed = $current_interval !== $interval;

            if ($interval_changed) {
                wp_schedule_event(time(), $interval_name, $schedule_name);
            }
        }

        if (!$next_scheduled) {
            wp_schedule_event(time(), $interval_name, $schedule_name);
        }

        add_action($schedule_name, $event);

    }

    public
    function delete(string $schedule_name): void
    {
        $cron_is_known = wp_next_scheduled($schedule_name);

        if ($cron_is_known) {
            wp_unschedule_event($cron_is_known, $schedule_name);
        }
    }


}