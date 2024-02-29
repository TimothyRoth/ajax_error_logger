<?php

namespace holyApi\Row;

interface RowInterface
{

    public function create(array $row, bool $error = false): mixed;

    public function read(int $row_id): mixed;

    public function update(array $post_array): mixed;

    public function delete(int $row_id, bool $force_delete = false): mixed;

    public function readTerms(int $row_id, string $taxonomy_name, array $args = []): mixed;

    public function addTerm(int $post_id, string $term, string $taxonomy_name): array|bool;

    public function removeTerm(int $row_id, string $term_name, string $taxonomy_name): bool;

}