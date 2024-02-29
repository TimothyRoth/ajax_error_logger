<?php

namespace holyApi\Column\WordPress;

use holyApi\Column\ColumnInterface;

class Column implements ColumnInterface
{
    public function create(int $table_id, string $column_name, mixed $value, bool $unique = false): int|bool
    {
        return add_post_meta($table_id, $column_name, $value, $unique);
    }

    public function read(int $row_id, string $column_name, bool $single = true): mixed
    {
        return get_post_meta($row_id, $column_name, $single);
    }

    public function update(int $row_id, string $column_name, $value): int|bool
    {
        return update_post_meta($row_id, $column_name, $value);
    }

    public function delete(int $row_id, string $column_name): bool
    {
        return delete_post_meta($row_id, $column_name);
    }


}