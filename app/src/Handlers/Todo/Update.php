<?php

declare(strict_types=1);

namespace App\Handlers\Todo;

use App\Domain\Todo\TodoEntity;
use App\Domain\Todo\TodoRepositoryInterface;
use App\Domain\Todo\ValueObjects\Id;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpNotFoundException;

class Update
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
        $post = $this->requestParams($request);
        $todo = $this->todoRepository->findById($id);
        assert($todo instanceof TodoEntity);
        $todo = $todo->withSubject($post['subject'])->withBody($post['body']);
        $this->todoRepository->save($todo);
        return $response->withHeader('location', '/todos');
    }

    /** @return array<string, string> */
    private function requestParams(Request $request): array
    {
        $post = $request->getParsedBody();
        assert(is_array($post));
        return [
            'subject' => $post['subject'],
            'body' => $post['body'],
        ];
    }
}
