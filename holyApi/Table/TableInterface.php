<?php

namespace holyApi\Table;

interface TableInterface
{
    public function create(string $table_name, bool $auto_hook = false, bool $show_in_menu = true, $public = false, $has_archive = false, string $menu_icon = "dashicons-admin-post"): mixed;

    public function drop(string $table_name, bool $auto_hook = false): mixed;

    public function query(array $query_args): mixed;

}