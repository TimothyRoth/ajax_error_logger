<?php

namespace HolyApi\Script;

interface ScriptInterface
{
    public function remove(string $handle): void;

    public function add(string $handle, string $src, array $deps = [], mixed $ver = false, bool $in_footer = false): void;

    public function addStylesheet(string $handle, string $src, array $deps = [], mixed $ver = false, string $media = 'all'): void;

    public function patch(string $handle, string $object_name, array $l10n): void;

}