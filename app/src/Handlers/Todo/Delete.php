<?php

declare(strict_types=1);

namespace App\Handlers\Todo;

use App\Domain\Todo\TodoRepositoryInterface;
use App\Domain\Todo\ValueObjects\Id;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpInternalServerErrorException;

class Delete
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
        if (!isset($id)) {
            throw new HttpNotFoundException($request);
        }
        $id = new Id($id);
        if (!$this->todoRepository->exists($id)) {
            throw new HttpNotFoundException($request);
        }
        if (!$this->todoRepository->delete($id)) {
            throw new HttpInternalServerErrorException($request);
        }
        return $response->withHeader('location', '/todos');
    }
}
