<?php

declare(strict_types=1);

namespace App\Domain\Todo;

use App\Domain\Todo\ValueObjects\Id;
use App\Domain\Todo\ValueObjects\Subject;
use App\Domain\Todo\ValueObjects\Body;

class TodoEntity
{
    /** @var Id */
    private Id $id;
    
    /** @var Subject */
    private Subject $subject;
    
    /** @var Body */
    private Body $body;
 
    public function __construct(Id $id, Subject $subject, Body $body)
    {
        $this->id = $id;
        $this->subject = $subject;
        $this->body = $body;
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public function getSubject(): string
    {
        return (string) $this->subject;
    }

    public function getBody(): string
    {
        return (string) $this->body;
    }

    public function withSubject(string $subject): self
    {
        return new self(
            $this->id,
            new Subject($subject),
            $this->body
        );
    }

    public function withBody(string $body): self
    {
        return new self(
            $this->id,
            $this->subject,
            new Body($body)
        );
    }

    public static function generate(string $subject, string $body): self
    {
        return new self(
            Id::generate(),
            new Subject($subject),
            new Body($body)
        );
    }
}
