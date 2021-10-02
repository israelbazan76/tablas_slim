<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TablasAction
{
    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {
        //$num = $request->getAttribute('num', 1);
        //$start = $request->getAttribute('start', 1);
        $response->getBody()->write('Tablas!');

        return $response;
    }
}