<?php

declare(strict_types=1);

namespace App\Handlers\Todo;

use App\Domain\Todo\TodoEntity;
use App\Domain\Todo\ValueObjects\Id;
use App\Domain\Todo\TodoRepositoryInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpNotFoundException;

class Edit
{
    /** @var TodoRepositoryInterface */
    private TodoRepositoryInterface $todoRepository;
    
    public function __construct(TodoRepositoryInterface $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $id = $request->getAttribute('id');
        if (is_null($id)) {
            throw new HttpNotFoundException($request);
        }
        $id = new Id($id);
        if (!$this->todoRepository->exists($id)) {
            throw new HttpNotFoundException($request);
        }
        $todo = $this->todoRepository->findById($id);
        assert($todo instanceof TodoEntity);

        $response->getBody()->write($this->render($todo));
        return $response;
    }

    private function render(TodoEntity $todo): string
    {
        return <<<HTML
<form method="POST" action="/todos/update/{$todo->getId()}">
<input type="text" name="subject" value="{$todo->getSubject()}">
<input type="text" name="body" value="{$todo->getBody()}">
<button type="submit">更新</button>
HTML;
    }
}
