<?php

namespace HolyApi\Script\WordPress;

use HolyApi\Script\ScriptInterface;

class Script implements ScriptInterface
{


    public function remove(string $handle): void
    {
        wp_deregister_script($handle);
    }

    public function add(string $handle, string $src, array $deps = [], mixed $ver = false, bool $in_footer = false): void
    {
        wp_enqueue_script($handle, $src, $deps, $ver, $in_footer);
    }

    public function addStylesheet(string $handle, string $src, array $deps = [], mixed $ver = false, string $media = 'all'): void
    {
        wp_enqueue_style($handle, $src, $deps, $ver, $media);
    }

    public function patch(string $handle, string $object_name, array $l10n): void
    {
        wp_localize_script($handle, $object_name, $l10n);
    }

}