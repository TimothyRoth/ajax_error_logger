<?php

declare(strict_types=1);

namespace app\Modal\Log;

/**
 * Class Log
 *
 * Class representing a error_logs modal.
 *
 */
class Log
{
    private string $timestamp;
    private string $request_method;
    private string $request_data;
    private string $error_message;
    private string $http_status;
    private string $send_status;
    private int $row_id;

    public function __construct(array $log = [])
    {
        $this->error_message = $log['errorMsg'] ?? 'No error message provided';
        $this->http_status = $log['httpStatus'] ?? 'No http status provided';
        $this->request_data = $log['requestData'] ?? 'No request data provided';
        $this->request_method = $log['requestMethod'] ?? 'No request method provided';
        $this->timestamp = $log['timestamp'] ?? 'No timestamp provided';
        $this->send_status = $log['sendStatus'] ?? 'unknown';
    }

    public function setRequestMethod(string $request_method): void
    {
        $this->request_method = $request_method;
    }

    public function setRequestData(string $request_data): void
    {
        $this->request_data = $request_data;
    }

    public function setTimestamp(string $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    public function setErrorMessage(string $error_message): void
    {
        $this->error_message = $error_message;
    }

    public function setHttpStatus(string $http_status): void
    {
        $this->http_status = $http_status;
    }

    public function setSendStatus(string $send_status): void
    {
        $this->send_status = $send_status;
    }

    public function setPostID(int $row_id): void
    {
        $this->row_id = $row_id;
    }

    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    public function getRequestMethod(): string
    {
        return $this->request_method;
    }

    public function getRequestData(): string
    {
        return $this->request_data;
    }

    public function getErrorMessage(): string
    {
        return $this->error_message;
    }

    public function getHttpStatus(): string
    {
        return $this->http_status;
    }

    public function getSendStatus(): string
    {
        return $this->send_status;
    }

    public function getRowId(): int
    {
        return $this->row_id;
    }


}
