<?php

declare(strict_types=1);

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

use App\Domain\Todo\TodoRepositoryInterface;
use App\Handlers\Todo\Index;
use App\Handlers\Todo\Create;
use App\Handlers\Todo\Store;
use App\Handlers\Todo\Edit;
use App\Handlers\Todo\Update;
use App\Infra\InMemoryTodoRepository;

$container = new Container();
$container->set(TodoRepositoryInterface::class, new InMemoryTodoRepository());

/** @var Slim\App */
$app = AppFactory::createFromContainer($container);

//$app->addErrorMiddleware(true, true, true);

$app->get('/', function (Request $request, Response $response): Response {
    $response->getBody()->write('hello world');
    return $response;
});

$app->get('/todos', Index::class);
$app->get('/todos/create', Create::class);
$app->post('/todos/store', Store::class);
$app->get('/todos/edit/{id}', Edit::class);
$app->post('/todos/update/{id}', Update::class);
$app->delete('/todos/delete//{id}', Delete::class);

$app->run();
