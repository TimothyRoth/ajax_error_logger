<?php

namespace app\View\Settings;

use app\App;
use app\Database\Tables\LogTable;
use app\Services\Log\Repository\UpdateLogRepositoryService;
use app\View\Settings\LogFilter\LogFilter;
use app\View\Settings\LogTable\LogTableBody;
use app\View\Settings\LogTable\LogTableHead;
use app\View\Settings\ViewCounter\ViewCounter;
use app\View\Settings\BulkAction\BulkAction;
use app\View\Settings\GeneralSettings\GeneralSettings;
use app\View\ViewInterface;

/**
 * Class AppSettingsView
 *
 * Class responsible for rendering the application settings view.
 */
class AppSettingsView implements ViewInterface
{
    public function render(mixed $meta = null): string
    {
        ob_start(); ?>
        <div class="ajax-error-logs-settings">
            <div class="welcome-area hide-in-settings">
                <div class="circle"></div>
                <div class="text">
                    <h1>Willkommen bei <?= PLUGIN_NAME ?>!</h1>
                    <p>
                        Hier können Sie die Einstellungen für <?= PLUGIN_NAME ?> anpassen und Fehlermeldungen einsehen.
                    </p>
                </div>
            </div>
            <div class="settings-tabs hide-in-settings">
                <div class="single-tab logs" id="ajax-error-logs-settings-tab-logs"
                     data-target="ajax-error-settings-dialogue-logs">Fehlermeldungen
                </div>
                <div class="single-tab settings" id="ajax-error-logs-settings-tab-settings"
                     data-target="ajax-error-settings-dialogue-settings">Einstellungen
                </div>
            </div>
            <div class="settings-dialogue">
                <div class="single-dialogue" id="ajax-error-settings-dialogue-logs">
                    <div class="top">
                        <p class="back-to-settings"><img src="<?= PLUGIN_URI ?>/assets/icons/back.svg"</p>
                        <h2 class="log-before">Fehlermeldungen</h2>
                    </div>
                    <div class="top-bar">
                        <?= App::make(LogFilter::class)->render($meta) ?>
                        <?= App::make(BulkAction::class)->render() ?>
                        <div class="trigger-mail-wrapper">
                            <div class="trigger-send-mail">Offene Logs senden</div>
                        </div>
                    </div>
                    <div class="view-counter-wrapper">
                        <?= App::make(ViewCounter::class)->render($meta) ?>
                    </div>
                    <table class="ajax-error-logs-log-container">
                        <thead>
                        <?= App::make(LogTableHead::class)->render() ?>
                        </thead>
                        <tbody>
                        <?= App::make(LogTableBody::class)->render($meta['logs']) ?>
                        </tbody>
                    </table>
                </div>
                <div class="single-dialogue" id="ajax-error-settings-dialogue-settings">
                    <div class="top">
                        <p class="back-to-settings"><img src="<?= PLUGIN_URI ?>/assets/icons/back.svg"</p>
                        <h2 class="settings-before">Einstellungen</h2>
                    </div>
                    <div class="settings-wrapper">
                        <?= App::make(GeneralSettings::class)->render($meta['general_settings']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php return ob_get_clean();
    }
}
