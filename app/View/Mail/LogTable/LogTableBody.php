<?php

namespace app\View\Mail\LogTable;

use app\View\ViewInterface;

/**
 *
 * Class LogTableBody
 *
 * Class responsible for rendering the body of the log table.
 *
 **/
class LogTableBody implements ViewInterface
{
    public function render(mixed $meta = null): string
    {
        ob_start();
        foreach ($meta ?? [] as $log) { ?>
            <tr>
                <td style="border: 1px solid #767676; text-align: left; font-size: 17px; color: #767676; padding: 10px;"><?= $log->getTimestamp() ?></td>
                <td style="border: 1px solid #767676; text-align: left; font-size: 17px; color: #767676; padding: 10px;"><?= $log->getRequestData() ?></td>
                <td style="border: 1px solid #767676; text-align: left; font-size: 17px; color: #767676; padding: 10px;"><?= $log->getRequestMethod() ?></td>
                <td style="border: 1px solid #767676; text-align: left; font-size: 17px; color: #767676; padding: 10px;"><?= $log->getErrorMessage() ?></td>
                <td style="border: 1px solid #767676; text-align: left; font-size: 17px; color: #767676; padding: 10px;"><?= $log->getHttpStatus() ?></td>
            </tr>
        <?php }

        if (empty($meta)) { ?>
            <tr>
                <td style="border: 1px solid #767676; text-align: left; font-size: 17px; color: #767676; padding: 10px;">
                    -
                </td>
                <td style="border: 1px solid #767676; text-align: left; font-size: 17px; color: #767676; padding: 10px;">
                    -
                </td>
                <td style="border: 1px solid #767676; text-align: left; font-size: 17px; color: #767676; padding: 10px;">
                    -
                </td>
                <td style="border: 1px solid #767676; text-align: left; font-size: 17px; color: #767676; padding: 10px;">
                    -
                </td>
                <td style="border: 1px solid #767676; text-align: left; font-size: 17px; color: #767676; padding: 10px;">
                    -
                </td>
            </tr>
        <?php }

        return ob_get_clean();
    }
}