<?php

namespace holyApi\User\WordPress;

use holyApi\User\UserInterface;

class User implements UserInterface
{

    public function create(string $username, string $password, string $email = ""): mixed
    {
        return wp_create_user($username, $password, $email);
    }

    public function getBy(string $column_name, int|string $column_value): object|bool
    {
        return get_user_by($column_name, $column_value);
    }

    public function delete(int $id, int $reassign = null): bool
    {
        return wp_delete_user();
    }

    public function getCurrent(): object|bool
    {
        return wp_get_current_user();
    }

    public function isAdmin(): bool
    {
        return is_admin();
    }

    public function createColumn(int $user_id, string $meta_key, mixed $meta_value, bool $unique = false): int|false
    {
        return add_user_meta($user_id, $meta_key, $meta_value, $unique);
    }

    public function readColumn(int $user_id, string $key, bool $single = false): mixed
    {
        return get_user_meta($user_id, $key, $single);
    }

    public function updateColumn(int $user_id, string $meta_key, mixed $meta_value): int|bool
    {
        return update_user_meta($user_id, $meta_key, $meta_value);
    }

    public function deleteColumn(int $user_id, string $meta_key): bool
    {
        return delete_user_meta($user_id, $meta_key);
    }

}