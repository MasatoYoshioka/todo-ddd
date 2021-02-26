<?php

declare(strict_types=1);

namespace App\Domain\Todo\ValueObjects;

use InvalidArgumentException;

class Subject
{
    /** @var string */
    private string $subject;

    public function __construct(string $subject)
    {
        if (!$this->valify($subject)) {
            throw new InvalidArgumentException('invalid value for subject.');
        }
        $this->subject = $subject;
    }

    private function valify(string $value): bool
    {
        if ($value === '') {
            return false;
        }
        return true;
    }

    public function __toString(): string
    {
        return $this->subject;
    }
}
