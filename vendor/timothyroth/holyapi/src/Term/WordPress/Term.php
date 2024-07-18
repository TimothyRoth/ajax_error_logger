<?php

namespace HolyApi\Term\WordPress;

use HolyApi\Term\TermInterface;

class Term implements TermInterface
{
    public function create(string $term_name, string $taxonomy_name, bool $auto_hook = false, array $args = []): mixed
    {
        if ($auto_hook) {
            add_action('init', function () use ($term_name, $taxonomy_name, $args) {
                $term_info = wp_insert_term($term_name, $taxonomy_name, $args);
                is_wp_error($term_info) ? false : $term_info['term_id'];
            });
            return true;
        }

        $term_info = wp_insert_term($term_name, $taxonomy_name, $args);
        return is_wp_error($term_info) ? false : $term_info['term_id'];
    }


    public function read(int $term_id, string $taxonomy_name, array $args = []): object|bool
    {
        $term = get_term($term_id, $taxonomy_name, $args);
        return is_wp_error($term) ? false : (object)$term;
    }

    public function update(int $term_id, string $taxonomy_name, array $args = []): int|bool
    {
        $term_info = wp_update_term($term_id, $taxonomy_name, $args);
        return is_wp_error($term_info) ? false : $term_info['term_id'];
    }

    public function delete(int $term_id, string $taxonomy_name, array $args = []): int|bool
    {
        $term_info = wp_delete_term($term_id, $taxonomy_name, $args);
        return !is_wp_error($term_info);
    }

    public function getByTaxonomy(string $taxonomy_name): array|bool
    {
        return get_terms([
            'taxonomy' => $taxonomy_name,
            'hide_empty' => false,
        ]);
    }

    public function getBy(string $field, string $value, string $taxonomy_name, array $args = []): object|bool
    {
        return get_term_by($field, $value, $taxonomy_name, $args);
    }


}