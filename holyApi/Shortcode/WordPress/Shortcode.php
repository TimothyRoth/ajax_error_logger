<?php

namespace holyApi\Shortcode\WordPress;

use holyApi\Shortcode\ShortcodeInterface;

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