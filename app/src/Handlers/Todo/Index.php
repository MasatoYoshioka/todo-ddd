<?php

declare(strict_types=1);

namespace App\Handlers\Todo;

use App\Domain\Todo\TodoEntity;
use App\Domain\Todo\TodoRepositoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Index
{
    /** @var TodoRepositoryInterface */
    private TodoRepositoryInterface $todoRepository;
    
    public function __construct(TodoRepositoryInterface $todoResponse)
    {
        $this->todoRepository = $todoResponse;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $response->getBody()->write(
            $this->render(
                $this->todoRepository->findAll()
            )
        );
        return $response;
    }

    /**
     * @param TodoEntity[] $todos
     */
    private function render(array $todos): string
    {
        return implode('', array_map(function (TodoEntity $todo): string {
            return <<<HTML
<ul>
<li>{$todo->getId()}</li>
<li>{$todo->getSubject()}</li>
<li>{$todo->getBody()}</li>
</ul>
HTML;
        }, $todos));
    }
}
