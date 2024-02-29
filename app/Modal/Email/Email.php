<?php

declare(strict_types=1);

namespace app\Modal\Email;

/**
 * Class Email
 *
 * Class representing an email modal.
 *
 */
class Email
{
    private string $recipient;
    private string $subject;
    private string $message;
    private array $headers;

    public function __construct(string $recipient, string $subject, string $message, array $headers)
    {
        $this->recipient = $recipient;
        $this->subject = $subject;
        $this->message = $message;
        $this->headers = $headers;
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}
