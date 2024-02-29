<?php

namespace app\View;

/**
 * Interface ViewInterface
 *
 * This interface defines the contract for view classes.
 * View classes are responsible for rendering HTML views.
 *
 */
interface ViewInterface
{
    public function render(mixed $meta = null): string;
}
