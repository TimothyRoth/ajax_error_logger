<?php

namespace HolyApi\Taxonomy;

interface TaxonomyInterface
{

    public function create(string $taxonomy_name, string|array $table_name, bool $auto_hook = false): void;

    public function read(string $taxonomy_name): ?object;

    public function update(string $taxonomy_name, string $table_name, array $args = []): bool;

    public function delete(string $taxonomy_name, bool $auto_hook = false): bool;

}