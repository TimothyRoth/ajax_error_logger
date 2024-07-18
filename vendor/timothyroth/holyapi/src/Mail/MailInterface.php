<?php

namespace HolyApi\Mail;

interface MailInterface
{
    public function send(string $to, string $subject, string $message, string|array $headers = '', string|array $attachments = ""): bool;
}