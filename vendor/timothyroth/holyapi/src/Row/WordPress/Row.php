<?php

namespace HolyApi\Row\WordPress;

use HolyApi\Row\RowInterface;

class Row implements RowInterface
{

    public function create(array $row, bool $error = false): mixed
    {
        return wp_insert_post($row, $error);
    }

    public function read(int $row_id): mixed
    {
        return get_post($row_id);
    }

    public function update(array $post_array): mixed
    {
        return wp_update_post($post_array);
    }

    public function delete(int $row_id, bool $force_delete = false): mixed
    {
        return wp_delete_post($row_id, $force_delete);
    }

    public function addTerm(int $post_id, string $term, string $taxonomy_name): array|bool
    {
        if (term_exists($term, $taxonomy_name)) {
            $term_object = get_term_by('name', $term, $taxonomy_name);
            $term_id = $term_object->term_id;
        } else {
            $term_info = wp_insert_term($term, $taxonomy_name);
            if (is_wp_error($term_info)) {
                return false;
            }
            $term_id = $term_info['term_id'];
        }

        $result = wp_set_object_terms($post_id, $term_id, $taxonomy_name, true);
        return is_wp_error($result) ? false : $result;
    }

    public function removeTerm(int $row_id, string $term_name, string $taxonomy_name): bool
    {
        $term_object = get_term_by('name', $term_name, $taxonomy_name);
        if ($term_object === false) {
            return false;
        }

        $term_id = $term_object->term_id;
        $term_ids = wp_get_object_terms($row_id, $taxonomy_name, array('fields' => 'ids'));
        if (is_wp_error($term_ids)) {
            return false;
        }

        $key = array_search($term_id, $term_ids, true);
        if ($key !== false) {
            unset($term_ids[$key]);
        }

        $result = wp_set_object_terms($row_id, $term_ids, $taxonomy_name);
        return is_wp_error($result) ? false : true;
    }

    public function readTerms(int $row_id, string $taxonomy_name, array $args = []): mixed
    {
        return wp_get_post_terms($row_id, $taxonomy_name, $args);
    }

}