<?php

namespace HolyApi\Column;

interface ColumnInterface
{

    public function create(int $table_id, string $column_name, mixed $value, bool $unique = false): int|bool;

    public function read(int $row_id, string $column_name, bool $single = true): mixed;

    public function update(int $row_id, string $column_name, mixed $value): int|bool;

    public function delete(int $row_id, string $column_name): bool;

}