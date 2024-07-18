<?php

namespace app\View\Settings\LogTable;

use app\View\ViewInterface;

class LogTableBody implements ViewInterface
{
    public function render(mixed $meta = null): string
    {
        ob_start();
        foreach ($meta ?? [] as $log) { ?>
            <tr>
                <td class="checkbox-td"><input type="checkbox" class="select-single-log"
                                               value="<?= $log->getRowId() ?>"></td>
                <td><?= $log->getTimestamp() ?></td>
                <td><?= $log->getRequestData() ?></td>
                <td><?= $log->getRequestMethod() ?></td>
                <td><?= $log->getErrorMessage() ?></td>
                <td><?= $log->getHttpStatus() ?></td>
                <td><?= $log->getSendStatus() ?></td>
            </tr>
        <?php }

        if (empty($meta)) { ?>
            <tr>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            </tr>
        <?php }

        return ob_get_clean();
    }
}