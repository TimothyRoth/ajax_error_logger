<?php

declare(strict_types=1);

namespace app\Settings;

use app\App;
use app\Database\Tables\LogTable;
use app\View\Settings\AppSettingsView;

/**
 * Class AppSettings
 *
 * Class responsible for managing application settings.
 *
 **/
readonly class AppSettings
{

    public string $mail_recipient_setting;
    public string $mail_cc_setting;
    public string $mail_bcc_setting;
    public string $mail_use_time_interval_setting;
    public string $mail_time_interval_setting;
    public string $error_exceptions_setting;
    public string $activate_log_threshold_setting;
    public string $log_threshold_setting;
    public array $time_intervals;
    public array $filter_options;

    public function __construct()
    {
        $this->mail_recipient_setting = PLUGIN_TEXT_DOMAIN . '_mail_recipient_setting';
        $this->mail_cc_setting = PLUGIN_TEXT_DOMAIN . '_mail_cc_setting';
        $this->mail_bcc_setting = PLUGIN_TEXT_DOMAIN . '_mail_bcc_setting';
        $this->mail_use_time_interval_setting = PLUGIN_TEXT_DOMAIN . '_mail_use_time_interval_setting';
        $this->mail_time_interval_setting = PLUGIN_TEXT_DOMAIN . '_mail_time_interval_setting';
        $this->error_exceptions_setting = PLUGIN_TEXT_DOMAIN . '_error_exceptions_setting';
        $this->activate_log_threshold_setting = PLUGIN_TEXT_DOMAIN . '_activate_log_threshold_setting';
        $this->log_threshold_setting = PLUGIN_TEXT_DOMAIN . '_log_threshold_setting';

        /*
       * Passing the different filter options to the view to map them as key value pairs for the options in the select input
       * Example: <option value={$key}>{$value}</option>
       * These values will be retrieved directly from this instance because they are readonly.
       * */

        $this->time_intervals = [
            "7200" => 'Alle 2 Stunden',
            "14400" => 'Alle 4 Stunden',
            "28800" => 'Alle 8 Stunden',
            "86400" => 'Jeden Tag',
            "172800" => 'Alle 2 Tage',
            "259200" => 'Alle 3 Tage',
            "345600" => 'Alle 4 Tage',
            "432000" => 'Alle 5 Tage',
            "518400" => 'Alle 6 Tage',
            "604800" => 'Einmal pro Woche'
        ];
        $this->filter_options = [
            'order' => [
                App::make(LogTable::class)->getOrderAscending() => 'Aufsteigend',
                App::make(LogTable::class)->getOrderDescending() => 'Absteigend'
            ],
            'status' => [
                "" => 'Alle',
                App::make(LogTable::class)->getStatusOpen() => 'Offen',
                App::make(LogTable::class)->getStatusSent() => 'Versendet',
            ],
            'amount' => [
                "10" => "10",
                "25" => "25",
                "50" => "50",
                "100" => "100",
                "-1" => "Alle"
            ]
        ];

        /*
         * Executing the methods to load the default settings and the plugin settings page.
         * */
        $this->loadDefaultSettings();
        $this->loadPluginSettingPage();

    }

    private function loadDefaultSettings(): void
    {
        /*
         * These are the default settings for the plugin that will be set on activation.
         * */
        App::Hooks()->executeOnPluginActivation(PLUGIN_BASENAME, function () {

            $default_settings = [
                $this->mail_recipient_setting => App::Setting()->read('admin_email'),
                $this->mail_cc_setting => '',
                $this->mail_bcc_setting => '',
                $this->mail_use_time_interval_setting => 'true',
                $this->mail_time_interval_setting => '7200',
                $this->error_exceptions_setting => '',
                $this->activate_log_threshold_setting => 'false',
                $this->log_threshold_setting => "1"
            ];

            foreach ($default_settings as $setting_name => $default_value) {
                if (App::Setting()->read($setting_name) === false) {
                    App::Setting()->create($setting_name, $default_value);
                }
            }

        });

    }

    private function prepareSettingsMeta(): array
    {
        /*
         * Preparing the settings_meta array to pass the settings to the view
         * */

        $settings_meta = [];
        $logs = [];

        /*
         * Retrieving the initial 10 logs from the database
         * */

        $log_query = App::make(LogTable::class)->query(
            [
                'posts_per_page' => 10,
            ]
        );

        foreach ($log_query as $log) {
            /*
             * Saving the log instances inside an array
             * */
            $logs[] = App::make(LogTable::class)->getLog($log->ID);
        }

        /*
         * Passing the collected log instances to the settings_meta
         * */

        $settings_meta['logs'] = $logs;

        $total_repository_entries = count(App::make(LogTable::class)->query());
        $settings_meta['total'] = $total_repository_entries;

        /*
         * Mapping the settings and their values to make them easier to access in the view
         * Example: $settings_meta[{setting_name}] = App::Setting()->read({setting_name});
         * */
        $settings_meta['general_settings'] =
            [
                $this->mail_recipient_setting => App::Setting()->read($this->mail_recipient_setting),
                $this->mail_cc_setting => App::Setting()->read($this->mail_cc_setting),
                $this->mail_bcc_setting => App::Setting()->read($this->mail_bcc_setting),
                $this->mail_use_time_interval_setting => App::Setting()->read($this->mail_use_time_interval_setting),
                $this->mail_time_interval_setting => App::Setting()->read($this->mail_time_interval_setting),
                $this->error_exceptions_setting => App::Setting()->read($this->error_exceptions_setting),
                $this->activate_log_threshold_setting => App::Setting()->read($this->activate_log_threshold_setting),
                $this->log_threshold_setting => App::Setting()->read($this->log_threshold_setting)
            ];

        $settings_meta['filter'] = $this->filter_options;
        $settings_meta['time_intervals'] = $this->time_intervals;

        return $settings_meta;
    }

    private function loadPluginSettingPage(): void
    {
        /*
         * Passing the parameters to generate the settings page
         * */
        App::Setting()->createMenuPage(
            __(PLUGIN_NAME, PLUGIN_TEXT_DOMAIN),
            __(PLUGIN_NAME, PLUGIN_TEXT_DOMAIN),
            'manage_options',
            'LogTable',
            function () {
                echo App::make(AppSettingsView::class)->render($this->prepareSettingsMeta());
            }, true
        );

        /*
         * Registering the settings to the WordPress settings API
         * So the values will be saved in the database
         * */
        App::Setting()->updateSettings(
            [
                $this->mail_recipient_setting,
                $this->mail_cc_setting,
                $this->mail_bcc_setting,
                $this->mail_use_time_interval_setting,
                $this->mail_time_interval_setting,
                $this->error_exceptions_setting,
                $this->activate_log_threshold_setting,
                $this->log_threshold_setting
            ]
        );
    }

    public function getHttpStatusExceptions(): array
    {
        return array_filter(
            array_map('trim', explode(',', App::Setting()->read($this->error_exceptions_setting)))
        );

    }

}
