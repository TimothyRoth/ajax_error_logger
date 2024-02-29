<?php

declare(strict_types=1);

namespace app\Services\Log\Repository;

use app\App;
use app\Database\Tables\LogTable;
use app\Modal\Log\Log;

/**
 * Class UpdateLogRepositoryService
 *
 * Class responsible for adding logs to the Archive Repository.
 *
 */
class UpdateLogRepositoryService
{

    public function __construct()
    {
        App::Ajax()->register(
            [
                'writeErrorLog' => [$this, 'writeErrorLog'],
                'testModule' => 'testModule',
            ]
        );
    }

    /**
     * @throws \JsonException
     */
    public function writeErrorLog(): void
    {
        /*
         * Retrieving the log from the Client and adding it to the database.
         * Initiating a new Log object and adding it to the database.
         * */
        $received_error_log = $_POST['errorLog'];
        $log = new Log($received_error_log);

        App::make(LogTable::class)->addLogEntry($log);
    }

    /**
     * @throws \JsonException
     */
    public function testModule(): void
    {
        /*
         * Module to provoke an error message for testing purposes.
         * This specific module is returning a 400 error.
         * */
        App::Ajax()->respond(['error' => 'testModule']);
    }

}
