<?php

declare(strict_types=1);

namespace App\Handlers\Todo;

use App\Domain\Todo\TodoEntity;
use App\Domain\Todo\TodoRepositoryInterface;
use DI\Definition\Exception\InvalidAnnotation;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class Store
{
    /** @var TodoRepositoryInterface */
    private TodoRepositoryInterface $todoRepository;

    public function __construct(TodoRepositoryInterface $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }
    
    public function __invoke(Request $request, Response $response): Response
    {
        $params = $request->getParsedBody();
        if (is_null($params)) {
            throw new HttpBadRequestException($request);
        }

        $post = $this->requestParams($request);

        $todo = TodoEntity::generate(
            $post['subject'],
            $post['body']
        );
        $ret = $this->todoRepository->save($todo);
        if (!$ret) {
            throw new HttpBadRequestException($request);
        }
        return $response->withHeader('location', '/todos');
    }

    /** @return array<string, string> */
    private function requestParams(Request $request): array
    {
        $post = $request->getParsedBody();
        assert(is_array($post));
        return [
            'subject' => $post['subject'],
            'body' => $post['body']
        ];
    }
}
