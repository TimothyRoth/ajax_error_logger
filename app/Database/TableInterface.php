<?php

declare(strict_types=1);

namespace app\Database;

/**
 * Interface LogRepositoryInterface
 *
 * This interface defines the contract for table classes.
 * Table classes are responsible for managing data storage and retrieval.
 *
 */
interface TableInterface
{
    public function query(array $args = null): array;

    public function addLogEntry(mixed $entry): void;

    public function getTableName(): string;

}
