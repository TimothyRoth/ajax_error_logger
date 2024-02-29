<?php

namespace app\View\Settings\LogFilter;

use app\App;
use app\View\ViewInterface;
use app\Database\Tables\LogTable;

class LogFilter implements ViewInterface
{

    public function render(mixed $meta = null): string
    {
        ob_start(); ?>

        <div class="log-filter">
            <div>
                <label for="log-filter-by-status"><b>Log Status</b></label>
                <select name="log-filter-by-status" id="log-filter-by-status">
                    <?php foreach ($meta['filter']['status'] as $value => $status) { ?>
                        <option value=<?= $value ?>><?= $status ?></option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label for="log-filter-by-order"><b>Sortierung</b></label>
                <select name="log-filter-by-order" id="log-filter-by-order">
                    <?php foreach ($meta['filter']['order'] as $value => $order) { ?>
                        <option value=<?= $value ?>><?= $order ?></option>;
                    <?php } ?>
                </select>
            </div>
            <div>
                <label for="log-filter-amount"><b>Anzahl</b></label>
                <select name="log-filter-amount" id="log-filter-amount">
                    <?php foreach ($meta['filter']['amount'] as $value => $amount) { ?>
                        <option value="<?= $value ?>"><?= $amount ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <?php return ob_get_clean();

    }
}