<?php

namespace app\View\Settings\BulkAction;

use app\View\ViewInterface;

class BulkAction implements ViewInterface
{

    public function render(mixed $meta = null): string
    {
        ob_start(); ?>
        <div class="bulk-action">
            <div>
                <label for="bulk-action-select"><b>Mehrfachauswahl</b></label>
                <select name="bulk-action-select" id="bulk-action-select">
                    <option value="deleteLogs">Auswahl Löschen</option>
                    <option value="exportLogs">Auswahl Exportieren</option>
                </select>
            </div>
            <div>
                <div class="bulk-action-button">Anwenden</div>
            </div>
        </div>
        <?php return ob_get_clean();
    }
}