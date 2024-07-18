<?php

namespace HolyApi\Mail\WordPress;

use HolyApi\Mail\MailInterface;

class Mail implements MailInterface
{
    public function send(string $to, string $subject, string $message, string|array $headers = '', string|array $attachments = ''): bool
    {
        return wp_mail($to, $subject, $message, $headers, $attachments);
    }

}