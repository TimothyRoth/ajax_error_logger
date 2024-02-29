<?php

namespace app\View\Settings\LogTable;

use app\View\ViewInterface;

class LogTableHead implements ViewInterface
{
    public function render(mixed $meta = null): string
    {
        ob_start(); ?>

        <tr>
            <th class="select-all"><b>Auswahl</b></th>
            <th><b>Zeitstempel</b></th>
            <th><b>Anfrage</b></th>
            <th><b>Methode</b></th>
            <th><b>Fehlermeldung</b></th>
            <th><b>HTTP-Status</b></th>
            <th><b>Mail-Status</b></th>
        </tr>

        <?php return ob_get_clean();
    }
}