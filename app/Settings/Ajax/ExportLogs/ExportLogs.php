<?php

namespace app\Settings\Ajax\ExportLogs;

use app\App;
use app\Database\Tables\LogTable;
use League\Csv\UnavailableStream;
use League\Csv\Writer;
use JsonException;

/**
 *
 * Class ExportLogs
 *
 * Implementing Ajax method for exporting logs.
 *
 **/
class ExportLogs
{
    public function __construct()
    {
        App::Ajax()->register(
            [
                'exportLogs' => [$this, 'exportLogs']
            ]
        );
    }

    /**
     * @throws JsonException
     * @throws UnavailableStream
     */
    public function exportLogs(): void
    {
        $log_ids = $_POST['logIDs'];
        $result = [];

        /*
         * Check if the client has selected logs to export and respond with an error message if not.
         * */
        if (empty($log_ids)) {
            App::Ajax()->respond(['message' => 'Es wurden keine Logs ausgewählt.']);
        }

        /*
         * Defining the first row of the CSV file.
         * */

        $result[] = ['Zeitstempel', 'Anfrage', 'Methode', 'Fehlermeldung', 'HTTP-Status', 'WordPress-Status'];


        /*
         * Loop through the selected logs and add them to the result array.
         * Each iteration will fill one row of the CSV file in given order.
         * */
        foreach ($log_ids as $logId) {
            $log = App::make(LogTable::class)->getLog((int)$logId);
            $result[] = [
                $log->getTimestamp(),
                $log->getRequestData(),
                $log->getRequestMethod(),
                $log->getErrorMessage(),
                $log->getHttpStatus(),
                $log->getSendStatus()
            ];
        }

        /*
         * Defining the file location and metadata.
         * */
        $name = PLUGIN_TEXT_DOMAIN . '-' . date('m-d-Y', time()) . '.csv';
        $writer = Writer::createFromPath(PLUGIN_PATH . '/exportFiles/' . $name, 'w+');
        $writer->insertAll($result);

        /*
         * Responding to the client with the file location.
         * */
        App::Ajax()->respond(
            [
                'file' => PLUGIN_URI . '/exportFiles/' . $name
            ]
        );
    }

}