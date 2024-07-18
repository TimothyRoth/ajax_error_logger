<?php

namespace app\View\Mail\LogTable;

use app\View\ViewInterface;

/**
 *
 * Class LogTableHead
 *
 * Class responsible for rendering the head of the log table.
 *
 **/
class LogTableHead implements ViewInterface
{
    public function render(mixed $meta = null): string
    {
        ob_start(); ?>

        <tr>
            <th style="border: 1px solid #767676; text-align: left; font-size: 17px; color: #767676; padding: 10px; font-weight: 500;">
                <b>Zeitstempel</b></th>
            <th style="border: 1px solid #767676; text-align: left; font-size: 17px; color: #767676; padding: 10px; font-weight: 500;">
                <b>Anfrage</b></th>
            <th style="border: 1px solid #767676; text-align: left; font-size: 17px; color: #767676; padding: 10px; font-weight: 500;">
                <b>Methode</b></th>
            <th style="border: 1px solid #767676; text-align: left; font-size: 17px; color: #767676; padding: 10px; font-weight: 500;">
                <b>Fehlermeldung</b></th>
            <th style="border: 1px solid #767676; text-align: left; font-size: 17px; color: #767676; padding: 10px; font-weight: 500;">
                <b>HTTP-Status</b></th>
        </tr>

        <?php return ob_get_clean();
    }
}