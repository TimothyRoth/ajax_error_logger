<?php

declare(strict_types=1);

namespace app\Services\Log\Repository;

use app\App;
use app\Database\Tables\LogTable;
use app\Model\Log\Log;

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
                'writeErrorLog' => [$this, 'writeErrorLog']
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

}
