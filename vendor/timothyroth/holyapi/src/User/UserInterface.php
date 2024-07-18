<?php

namespace HolyApi\User;

interface UserInterface
{
    public function create(string $username, string $password, string $email = ""): mixed;

    public function delete(int $id, int $reassign = null): bool;

    public function getCurrent(): object|bool;

    public function isAdmin(): bool;

    public function getBy(string $column_name, int|string $column_value): object|bool;

    public function createColumn(int $user_id, string $meta_key, mixed $meta_value, bool $unique = false): int|false;

    public function readColumn(int $user_id, string $key, bool $single = false): mixed;

    public function updateColumn(int $user_id, string $meta_key, mixed $meta_value): int|bool;

    public function deleteColumn(int $user_id, string $meta_key): bool;


}