<?php

namespace app\View\Settings\ViewCounter;

use app\View\ViewInterface;

class ViewCounter implements ViewInterface
{
    public
    function render(mixed $meta = null): string
    {
        ob_start(); ?>
        <div class="view-counter">
            <p>Zeige <span id="current-view"><?= count($meta['logs']) ?></span> von <span
                        id="total-view"><?= $meta['total'] ?></span> Einträgen.</p>
        </div>
        <?php return ob_get_clean();
    }
}