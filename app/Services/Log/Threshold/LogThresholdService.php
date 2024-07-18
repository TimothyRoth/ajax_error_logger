<?php

namespace app\Services\Log\Threshold;

use app\App;
use app\Database\Tables\LogTable;
use app\Services\Cron\Mail\MailService;
use app\Settings\AppSettings;

class LogThresholdService
{
    public function __construct()
    {
        App::Ajax()->register(
            [
                'sendLogsAtThreshold' => [$this, 'sendLogsAtThreshold'],
            ]
        );
    }

    /**
     * @throws \JsonException
     */
    public function sendLogsAtThreshold(): void
    {
        /*
         * Checking if the threshold that is supposed to trigger a log report is reached
         * Responding with a message if the log report was sent successfully or not.
         * */

        if ($this->isLogThresholdReached()) {

            $log_report_send_successful = App::make(MailService::class)->sendMail();

            if ($log_report_send_successful) {
                App::make(LogTable::class)->setLogStatusToSent();
            }

            App::Ajax()->respond(['message' => $log_report_send_successful ? "Log Report sent successfully." : "No relevant logs available."]);
        }

        /*
         * Respond with a message if no log report was necessary.
         * */
        App::Ajax()->respond(['message' => "Log Report not necessary. Threshold has not been reached."]);

    }

    private function isLogThresholdReached(): bool
    {

        /*
         * if the setting is not active, no limit is active and therefore a log report should be sent.
         * */

        if (!$this->isLogThresholdSettingActive()) {
            return $this->isLogThresholdSettingActive();
        }

        /*
         * return true if the amount of logs necessary to trigger an e-mail has been reached.
         * */

        /** @var AppSettings $AppSettings */
        $AppSettings = App::make(AppSettings::class);
        $unsent_logs = App::make(LogTable::class)->countUnsentLogs();


        $log_threshold = (int)App::Setting()->read($AppSettings->log_threshold_setting);
        return $log_threshold <= $unsent_logs;
    }

    private function isLogThresholdSettingActive(): bool
    {
        /** @var AppSettings $AppSettings */
        $AppSettings = App::make(AppSettings::class);

        return App::Setting()->read($AppSettings->activate_log_threshold_setting) === "true";
    }


}