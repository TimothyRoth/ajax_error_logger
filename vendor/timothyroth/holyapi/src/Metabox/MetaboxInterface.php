<?php

namespace HolyApi\Metabox;

interface MetaboxInterface
{
    public function create(string $name, callable $callback, string|array $screen = null, bool $auto_hook = false, string $context = 'advanced', string $priority = 'default', array $callback_args = null);

    public function delete(string $id, string|array $screen, bool $auto_hook = false, string $context = 'advanced');

    public function updateFields(array $fields, bool $auto_hook = false): void;
}