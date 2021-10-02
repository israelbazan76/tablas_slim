<?php
namespace App;

use Slim\App;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Handler\HomePageHandler;
use App\Handler\TablasPageHandler;

return function (App $app) {
    //$app->get('/[{name}]', HomePageHandler::class)->setName('home');
    // $app->get('/', \App\Action\TablasAction::class)->setName('tablas');
    // $app->map(['GET','POST'],'/', \App\Action\TablasAction::class)->setName('tablas');
    //$app->get('/', \App\Action\TablasAction::class)->setName('tablas');
    // $app->get('/', function (Request $request, Response $response, $args) {
    //     $response->getBody()->write("Hello world!");
    //     return $response;
    // });
    //$app->get('/[{name}]', \App\Action\HomeAction::class)->setName('home');
    //$app->get('/[{num}[/{start}]]', TablasPageHandler::class)->setName('tablas');
    $app->map(['GET', 'POST'],'/[{num}[/{start}]]', TablasPageHandler::class)->setName('tablas');
};
