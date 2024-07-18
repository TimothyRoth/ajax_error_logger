<?php

namespace HolyApi\Shortcode\WordPress;

use HolyApi\Shortcode\ShortcodeInterface;

class Shortcode implements ShortcodeInterface
{
    public function create(string $tag, callable $callback): void
    {
        add_shortcode($tag, $callback);
    }

    public function render(string $content): string
    {
        return do_shortcode($content);
    }

}