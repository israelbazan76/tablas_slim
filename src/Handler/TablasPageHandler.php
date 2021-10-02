<?php

declare (strict_types = 1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Response;

class TablasPageHandler implements RequestHandlerInterface
{
    private $logger;
    private $twig;

    public function __construct(LoggerInterface $logger, \Twig\Environment $twig)
    {
        $this->logger = $logger;
        $this->twig = $twig;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->logger->info('Tablas page handler dispatched');
        $cols = 5;
        $num = $request->getAttribute('num', 1);
        $start = $request->getAttribute('start', 1);
    
        $data = $request->getParsedBody();
        if ($data) {
            if($data['number']){
                $data['number'] = trim($data['number']);
            }
            if ( !empty($data['number']) && \is_numeric($data['number']) && ((int)$data['number']>0)){
                  $num = (int)$data['number'];
            }else{
                $errors[] = 'Ingrese un número entero mayor a 0';
            }
        }
        $response = new Response();
        $response->getBody()->write(
            $this->twig->render('tablas-page.twig', ['num' => $num, 'start' => $start, 'cols' => $cols,'errors' => $errors])
        );
        return $response;
    }
}
