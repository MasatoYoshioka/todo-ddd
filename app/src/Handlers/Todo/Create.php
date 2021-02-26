<?php

declare(strict_types=1);

namespace App\Handlers\Todo;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Create
{
    public function __invoke(Request $request, Response $response): Response
    {
        $response->getBody()->write($this->render());
        return $response;
    }

    private function render(): string
    {
        return <<<HTML
<form action='store' method=post>
    <input type='text' name="subject">
    <input type='textarea' name="body">
    <button type='submit' >登録する</button>
</form>
HTML;
    }
}
