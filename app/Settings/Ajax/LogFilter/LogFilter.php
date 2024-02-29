<?php

namespace app\Settings\Ajax\LogFilter;

use app\App;
use app\Database\Tables\LogTable;
use app\View\Settings\LogTable\LogTableBody;

class LogFilter
{
    /**
     *
     * Class LogFilter
     *
     * Implementing Ajax method for filtering logs.
     *
     **/
    public function __construct()
    {
        App::Ajax()->register(
            [
                'logFilter' => [$this, 'logFilter']
            ]
        );
    }

    /**
     * @throws \JsonException
     */
    public function logFilter(): void
    {
        $filter_args = $_POST['filterQuery'];
        $logs = [];

        /*
         * Query the logs table with the filter arguments and add the logs to the logs array.
         * */
        foreach (App::make(LogTable::class)->query($filter_args) as $log) {
            $logs[] = App::make(LogTable::class)->getLog($log->ID);
        }

        /*
         * Respond to the client with:
         * - the HTML of the log table body
         * - the amount of logs currently displayed
         * - the total amount of logs
         * */

        $total_log_amount = App::make(LogTable::class)->query([
                'post_status' => $filter_args['post_status'] ?? null,
                'posts_per_page' => -1,
            ]
        );

        App::Ajax()->respond([
            'html' => App::make(LogTableBody::class)->render($logs),
            'current' => count($logs),
            'total' => count($total_log_amount),
        ]);
    }
}