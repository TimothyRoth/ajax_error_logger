<?php

declare(strict_types=1);

namespace app\Database\Tables;

use app\App;
use app\Database\TableInterface;
use app\Model\Log\Log;
use app\Settings\AppSettings;

/**
 * Class LogTable
 *
 * Table class for managing different CRUD operations.
 *
 **/
class LogTable implements TableInterface
{

    private string $name;
    private string $timestamp;
    private string $request_data;
    private string $request_method;
    private string $error_message;
    private string $http_status;
    private string $status_sent;
    private string $status_open;
    private string $order_ascending;
    private string $order_descending;

    public function __construct()
    {
        $this->name = "LogTable";
        $this->timestamp = "timestamp";
        $this->request_data = "requestData";
        $this->request_method = "requestMethod";
        $this->error_message = "errorMessage";
        $this->http_status = "httpStatus";
        $this->status_sent = "publish";
        $this->status_open = "draft";
        $this->order_ascending = "ASC";
        $this->order_descending = "DESC";


        App::Table()->create($this->name, true, false);
    }

    public function query(array $args = null): array
    {
        $query_args = [
            'post_type' => $this->name,
            'posts_per_page' => -1,
        ];

        if ($args !== null) {
            $query_args = array_merge($query_args, $args);
        }

        return (App::Table()->query($query_args))->posts;
    }

    public function setLogStatusToSent(): void
    {
        $logsToChange = $this->query([
            'post_status' => $this->status_open,
        ]);

        foreach ($logsToChange as $log) {
            App::Row()->update([
                'ID' => $log->ID,
                'post_status' => $this->status_sent,
            ]);
        }
    }

    public function collectLogs(): array|false
    {
        $response = [];

        /*
         * Only collect logs that have not been sent yet
         * */

        $logs = $this->query([
            'post_status' => $this->status_open,
        ]);

        /*
         * return false when no logs are available
         * */
        if (empty($logs)) {
            return false;
        }

        /*
         * get the http status exceptions from the settings
         * */
        $http_status_to_ignore = App::make(AppSettings::class)->getHttpStatusExceptions();

        foreach ($logs as $log) {

            $log_result = $this->getLog($log->ID);

            /*
             * Ignore logs with specific http status
             * */
            if (in_array($log_result->getHttpStatus(), $http_status_to_ignore, true)) {
                continue;
            }

            $response[] = $log_result;
        }

        /*
         * Return false if the response is empty after filtering
         * */

        if (empty($response)) {
            return false;
        }

        return $response;
    }

    public function countUnsentLogs(): int
    {
        return count($this->query(['post_status' => $this->status_open]));
    }

    public function addLogEntry(mixed $entry): void
    {
        /*
         * The create method returns the row id when a new row is created
         * */
        $row_id = App::Row()->create([
            'post_title' => 'Ajax Error Log ' . $entry->getTimestamp(),
            'post_type' => $this->name,
            'post_status' => $this->status_open,
        ]);

        $this->setTimestamp($row_id, $entry->getTimestamp());
        $this->setErrorMessage($row_id, $entry->getErrorMessage());
        $this->setHttpStatus($row_id, $entry->getHttpStatus());
        $this->setRequestMethod($row_id, $entry->getRequestMethod());
        $this->setRequestData($row_id, $entry->getRequestData());
    }

    public function getTableName(): string
    {
        return $this->name;
    }

    private function setTimestamp(int $row_id, string $timestamp): void
    {
        App::Column()->update($row_id, $this->name . '_' . $this->timestamp, $timestamp);
    }

    private function setHttpStatus(int $row_id, string $httpStatus): void
    {
        App::Column()->update($row_id, $this->name . '_' . $this->http_status, $httpStatus);
    }

    private function setErrorMessage(int $row_id, string $errorMessage): void
    {
        App::Column()->update($row_id, $this->name . '_' . $this->error_message, $errorMessage);
    }

    private function setRequestMethod(int $row_id, string $requestMethod): void
    {
        App::Column()->update($row_id, $this->name . '_' . $this->request_method, $requestMethod);
    }

    private function setRequestData(int $row_id, string $requestData): void
    {
        App::Column()->update($row_id, $this->name . '_' . $this->request_data, $requestData);
    }

    public function getTimestamp(int $row_id): string
    {
        return App::Column()->read($row_id, $this->name . '_' . $this->timestamp, true);
    }

    public function getHttpStatus(int $row_id): string
    {
        return App::Column()->read($row_id, $this->name . '_' . $this->http_status, true);
    }

    public function getErrorMessage(int $row_id): string
    {
        return App::Column()->read($row_id, $this->name . '_' . $this->error_message, true);
    }

    public function getRequestMethod(int $row_id): string
    {
        return App::Column()->read($row_id, $this->name . '_' . $this->request_method, true);
    }

    public function getRequestData(int $row_id): string
    {
        return App::Column()->read($row_id, $this->name . '_' . $this->request_data, true);
    }

    public function getSendStatus(int $row_id): string
    {
        /*
         * Map the post status to its domain context
         * */

        $sendStatus = [
            $this->status_open => 'offen',
            $this->status_sent => 'versendet',
        ];

        return $sendStatus[App::Row()->read($row_id)->post_status];
    }

    public function getStatusOpen(): string
    {
        return $this->status_open;
    }

    public function getStatusSent(): string
    {
        return $this->status_sent;
    }

    public function getOrderAscending(): string
    {
        return $this->order_ascending;
    }

    public function getOrderDescending(): string
    {
        return $this->order_descending;
    }

    public function getLog(int $row_id): Log
    {
        $log = new Log(
            [
                'timestamp' => $this->getTimestamp($row_id),
                'httpStatus' => $this->getHttpStatus($row_id),
                'errorMsg' => $this->getErrorMessage($row_id),
                'requestMethod' => $this->getRequestMethod($row_id),
                'requestData' => $this->getRequestData($row_id),
                'sendStatus' => $this->getSendStatus($row_id),
            ]);

        $log->setPostID($row_id);

        return $log;
    }

    public function deleteLogs(array $log_ids): void
    {
        foreach ($log_ids as $log_id) {
            App::Row()->delete((int)$log_id, true);
        }
    }

}
