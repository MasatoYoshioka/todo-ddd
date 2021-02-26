<?php

declare(strict_types=1);

namespace App\Domain\Todo\ValueObjects;

use InvalidArgumentException;

class Id
{
    /** @var string */
    private string $id;

    public function __construct(string $id)
    {
        if (!$this->valify($id)) {
            throw new InvalidArgumentException('invalid value for id');
        }
        $this->id = $id;
    }

    private function valify(string $id): bool
    {
        if ($id === '') {
            return false;
        }
        return true;
    }

    public function toNatural(): string
    {
        return (string) $this;
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public function equals(self $id): bool
    {
        if (spl_object_id($id) === spl_object_id($this)) {
            return true;
        }
        return $id->toNatural() === $this->id;
    }

    public static function generate(): self
    {
        return new self(uniqid());
    }
}
