<?php

namespace holyApi\Term;

interface TermInterface
{
    public function create(string $term_name, string $taxonomy_name, bool $auto_hook = false, array $args = []): mixed;

    public function read(int $term_id, string $taxonomy_name, array $args = []): object|bool;

    public function update(int $term_id, string $taxonomy_name, array $args = []): int|bool;

    public function delete(int $term_id, string $taxonomy_name, array $args = []): int|bool;

    public function getByTaxonomy(string $taxonomy_name): array|bool;

    public function getBy(string $field, string $value, string $taxonomy_name, array $args = []): object|bool;

}