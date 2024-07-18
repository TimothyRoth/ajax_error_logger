<?php

declare(strict_types=1);

namespace app\Services\Cron\Mail;

use app\App;
use app\Database\Tables\LogTable;
use app\Model\Email\Email;
use app\Settings\AppSettings;
use app\View\Mail\EmailTemplate;

/**
 * Class MailService
 *
 * Class responsible for managing application mails.
 *
 */
class MailService
{

    private string $schedule_name;

    public function __construct()
    {
        $this->schedule_name = 'send_mail';
        $this->toggleCronjob();
    }

    public function prepareEmailObject(): Email|false
    {

        /*
         * If there are no logs to send, return false.
         * */

        $logs_to_send = App::make(LogTable::class)->collectLogs();

        if (!$logs_to_send) {
            return $logs_to_send;
        }


        $headers = [
            'Content-Type: text/html; charset=UTF-8',
        ];

        /*
         * Check for the cc and bcc settings and append the headers if they are set.
         * */

        /** @var AppSettings $AppSettings readonly */
        $AppSettings = App::make(AppSettings::class);

        if (App::Setting()->read($AppSettings->mail_cc_setting) !== "") {
            $headers[] = 'Cc: ' . App::Setting()->read($AppSettings->mail_cc_setting);
        }

        if (App::Setting()->read($AppSettings->mail_bcc_setting) !== "") {
            $headers[] = 'Bcc: ' . App::Setting()->read($AppSettings->mail_bcc_setting);
        }

        /*
         * Return the email object passing the recipient, subject, message and headers to the constructor.
         * */

        return new Email(
            App::Setting()->read(App::make(AppSettings::class)->mail_recipient_setting),
            PLUGIN_NAME,
            App::make(EmailTemplate::class)->render($logs_to_send),
            $headers);
    }

    public function sendMail(): bool
    {
        /*
         * Retrieving the prepared email object which returns false if there are no logs to send.
         * If there are no logs to send, return false.
         * Else send the email.
         * */
        $email = $this->prepareEmailObject();

        if (!$email) {
            return $email;
        }

        return App::Mail()->send($email->getRecipient(), $email->getSubject(), $email->getMessage(), $email->getHeaders());
    }

    private function detectTimeInterval(): int
    {
        /** @var AppSettings $AppSettings */
        $AppSettings = App::make(AppSettings::class);

        /*
         * Return the time interval set by the user.
         * */

        return (int)App::Setting()->read($AppSettings->mail_time_interval_setting);

    }

    private function timeIntervalSettingIsActive(): bool
    {
        /*
         * Returns true if the user has set a custom time interval for the mail sending.
         * */

        /** @var AppSettings $AppSettings */
        $AppSettings = App::make(AppSettings::class);

        return App::Setting()->read($AppSettings->mail_use_time_interval_setting) === "true";
    }

    private function toggleCronjob(): void
    {
        /*
         * Check if the user has set a custom time interval for the mail sending.
         * IF true, register the cronjob and exit the method early.
         * ELSE do not register the cronjob and delete it, if there was one scheduled before.
         * */
        if ($this->timeIntervalSettingIsActive()) {
            App::Cron()->register(function () {
                if ($this->sendMail()) {
                    App::make(LogTable::class)->setLogStatusToSent();
                }
            }, $this->schedule_name, $this->detectTimeInterval());
            return;
        }

        App::Cron()->delete($this->schedule_name);

    }
}
