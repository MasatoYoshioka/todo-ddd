<?php

declare(strict_types=1);

namespace App\Domain\Todo\ValueObjects;

use InvalidArgumentException;

class Body
{
    /** @var string */
    private string $body;

    public function __construct(string $body)
    {
        if (!$this->valify($body)) {
            throw new InvalidArgumentException('invalid value is subject.');
        }
        $this->body = $body;
    }

    private function valify(string $body): bool
    {
        if ($body === '') {
            return false;
        }
        return true;
    }

    public function __toString(): string
    {
        return $this->body;
    }
}
