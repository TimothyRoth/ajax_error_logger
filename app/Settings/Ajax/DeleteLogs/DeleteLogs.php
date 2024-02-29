<?php

namespace app\Settings\Ajax\DeleteLogs;

use app\App;
use app\Database\Tables\LogTable;

/**
 *
 * Class DeleteLogs
 *
 * Implementing Ajax method for deleting logs.
 *
 **/
class DeleteLogs
{
    public function __construct()
    {
        App::Ajax()->register(
            [
                'deleteLogs' => [$this, 'deleteLogs']
            ]
        );
    }

    /**
     * @throws \JsonException
     */
    public function deleteLogs(): void
    {
        $log_ids = $_POST['logIDs'] ?? null;

        if (empty($log_ids)) {
            App::Ajax()->respond(['message' => 'Es wurden keine Logs ausgewählt.']);
        }

        /*
         * Checking if the client has selected logs to delete.
         * Responding with either the amount of logs deleted or an error message.
         * */
        $deleted_logs_amount = count($log_ids);
        App::make(LogTable::class)->deleteLogs($log_ids);
        App::Ajax()->respond(['message' => "Die Auswahl von {$deleted_logs_amount} Logs wurde erfolgreich gelöscht."]);

    }

}