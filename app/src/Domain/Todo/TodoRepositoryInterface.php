<?php

declare(strict_types=1);

namespace App\Domain\Todo;

use App\Domain\Todo\ValueObjects\Id;
use App\Domain\Todo\TodoEntity;

interface TodoRepositoryInterface
{
    public function findById(Id $id): ?TodoEntity;

    public function save(TodoEntity $todoEntity): bool;

    public function exists(Id $id): bool;

    /** @return array<string, TodoEntity> */
    public function findAll(): array;

    public function delete(Id $id): bool;
}
