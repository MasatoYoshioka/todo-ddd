<?php

declare(strict_types=1);

namespace App\Infra;

use App\Domain\Todo\TodoRepositoryInterface;
use App\Domain\Todo\TodoEntity;
use App\Domain\Todo\ValueObjects\Id;
use App\Domain\Todo\ValueObjects\Subject;
use App\Domain\Todo\ValueObjects\Body;

class InMemoryTodoRepository implements TodoRepositoryInterface
{
    /** @var array<string, TodoEntity> */
    private $todos = [];

    public function __construct()
    {
        foreach (range(0, 5) as $number) {
            $todo = TodoEntity::generate("subject{$number}", "body{$number}");
            $this->todos[$todo->getId()] = $todo;
        }
        $id = new Id('602f9834af15d');
        $this->todos[$id->toNatural()] = new TodoEntity(
            $id,
            new Subject('hoga'),
            new Body('fuga')
        );
    }

    public function findById(Id $id): ?TodoEntity
    {
        if (isset($this->todos[$id->toNatural()])) {
            return $this->todos[$id->toNatural()];
        }
        return null;
    }

    public function save(TodoEntity $todoEntity): bool
    {
        $this->todos[$todoEntity->getId()] = $todoEntity;
        return true;
    }

    public function exists(Id $id): bool
    {
        return isset($this->todos[$id->toNatural()]);
    }

    public function findAll(): array
    {
        return $this->todos;
    }

    public function delete(Id $id): bool
    {
        if (!isset($this->todos[$id->toNatural()])) {
            return false;
        }
        unset($this->todos[$id->toNatural()]);
        return true;
    }
}
