<?php

namespace app\View\Settings\GeneralSettings;

use app\App;
use app\View\ViewInterface;
use app\Settings\AppSettings;

class GeneralSettings implements ViewInterface
{
    public function render(mixed $meta = null): string
    {

        /** @var AppSettings $app_settings */
        $app_settings = App::make(AppSettings::class);
        ob_start(); ?>
        <form method="POST">
            <div class="seperator"><b>Allgemein</b></div>
            <p>
                <label for="<?= $app_settings->mail_recipient_setting ?>">Empfänger</label>
                <input type="text"
                       name="<?= $app_settings->mail_recipient_setting ?>"
                       id="<?= $app_settings->mail_recipient_setting ?>"
                       placeholder="Empfänger"
                       value="<?= $meta[$app_settings->mail_recipient_setting] ?>">
            </p>
            <p>
                <label for="<?= $app_settings->mail_cc_setting ?>">CC</label>
                <input type="text"
                       name="<?= $app_settings->mail_cc_setting ?>"
                       id="<?= $app_settings->mail_cc_setting ?>"
                       placeholder="CC"
                       value="<?= $meta[$app_settings->mail_cc_setting] ?>">
            </p>
            <p>
                <label for="<?= $app_settings->mail_bcc_setting ?>">BCC</label>
                <input type="text"
                       name="<?= $app_settings->mail_bcc_setting ?>"
                       id="<?= $app_settings->mail_bcc_setting ?>"
                       placeholder="BCC"
                       value="<?= $meta[$app_settings->mail_bcc_setting] ?>">
            </p>
            <div class="seperator"><b>Benachrichtigungen</b></div>
            <div>
                <p class="trigger-other-select">
                    <label for="<?= $app_settings->mail_use_time_interval_setting ?>">Log Reports in einem
                        festgelegten Zeitinerval versenden</label>
                    <select name="<?= $app_settings->mail_use_time_interval_setting ?>"
                            id="<?= $app_settings->mail_use_time_interval_setting ?>">
                        <option value="true" <?= $meta[$app_settings->mail_use_time_interval_setting] === 'true' ? 'selected' : ''; ?>>
                            Ja
                        </option>
                        <option value="false" <?= $meta[$app_settings->mail_use_time_interval_setting] === 'false' ? 'selected' : ''; ?>>
                            Nein
                        </option>
                    </select>
                </p>
                <p class="show-when-active">
                    <label for="<?= $app_settings->mail_time_interval_setting ?>">Zeiterinterval</label>
                    <select name="<?= $app_settings->mail_time_interval_setting ?>"
                            id="<?= $app_settings->mail_time_interval_setting ?>">
                        <?php foreach ($app_settings->time_intervals as $interval => $label) { ?>
                            <option value="<?php echo $interval; ?>" <?= ($meta[$app_settings->mail_time_interval_setting] == $interval) ? 'selected' : ''; ?>>
                                <?= $label; ?>
                            </option>
                        <?php } ?>
                    </select>
                </p>
            </div>
            <div>
                <p class="trigger-other-select">
                    <label for="<?= $app_settings->activate_log_threshold_setting ?>">Log Reports bei einer
                        festgelegten Fehleranzahl direkt versenden?</label>
                    <select name="<?= $app_settings->activate_log_threshold_setting ?>"
                            id="<?= $app_settings->activate_log_threshold_setting ?>">
                        <option value="true" <?= $meta[$app_settings->activate_log_threshold_setting] === 'true' ? 'selected' : ''; ?>>
                            Ja
                        </option>
                        <option value="false" <?= $meta[$app_settings->activate_log_threshold_setting] === 'false' ? 'selected' : ''; ?>>
                            Nein
                        </option>
                    </select>
                </p>
                <p class="show-when-active">
                    <label for="<?= $app_settings->log_threshold_setting ?>">Anzahl festlegen</label>
                    <input type="number" name="<?= $app_settings->log_threshold_setting ?>"
                           id="<?= $app_settings->log_threshold_setting ?>"
                           value="<?= $meta[$app_settings->log_threshold_setting] ?>">
                </p>
            </div>
            <p>
                <label for="<?= $app_settings->error_exceptions_setting ?>">Fehlerarten die in den Log Reports
                    ignoriert
                    werden sollen (Komma seperiert)</label>
                <input type="text" name="<?= $app_settings->error_exceptions_setting ?>"
                       id="<?= $app_settings->error_exceptions_setting ?>" placeholder="Http Status (z.B. 404, 500)"
                       value="<?= $meta[$app_settings->error_exceptions_setting] ?>">
            </p>

            <input type="submit" value="Speichern">
        </form>
        <?php return ob_get_clean();
    }

}