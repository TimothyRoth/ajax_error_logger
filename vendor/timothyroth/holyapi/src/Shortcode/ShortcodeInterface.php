<?php

namespace HolyApi\Shortcode;

interface ShortcodeInterface
{
    public function create(string $tag, callable $callback): void;

    public function render(string $content): string;
}