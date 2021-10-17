<?php

declare (strict_types = 1);

namespace App\Handler;

use Mobile_Detect;
use Slim\Psr7\Response;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;



class TablasPageHandler implements RequestHandlerInterface
{
    private $logger;
    private $twig;
    private $detect;
    const error_message = "Ingrese un número entero mayor a 0";

    public function __construct(LoggerInterface $logger, \Twig\Environment $twig)
    {
        $this->logger = $logger;
        $this->twig = $twig;
        $this->detect = new Mobile_Detect;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->logger->info('Tablas page handler dispatched');
        $cols = 5;
        $num = $request->getAttribute('num', 1);
        $start = $request->getAttribute('start', 1);
        $errors = [];
        
        // if(!$this->number_validation_success($num) ){
        //     $num = 1;
        //     $errors[] = self::error_message ;
        // }else{
        //     $num = (int)$num;
        // }
    
        $data = $request->getParsedBody();
        if ($data) {
            if($data['number']){
                $data['number'] = trim($data['number']);
            }
            $start = 1;
            if ( $this->number_validation_success($data['number']) ){
                $num = (int)$data['number'];
            }else{
                $num = 1;
                $errors[] = self::error_message;
            }
        }else{
            if(!$this->number_validation_success($num) ){
                $num = 1;
                $errors[] = self::error_message ;
            }else{
                $num = (int)$num;
            }
        }
        $response = new Response();

        if ($this->detect->isMobile()){
            $cols = 1;
            $response->getBody()->write(
                $this->twig->render('tablas-mobile.twig', ['num' => $num, 'start' => $start, 'cols' => $cols,'errors' => $errors])
            );
        }else{
            $response->getBody()->write(
                $this->twig->render('tablas-page.twig', ['num' => $num, 'start' => $start, 'cols' => $cols,'errors' => $errors])
            );
        }
        
        return $response;
    }
    private function number_validation_success($number){
      return !empty($number) && \is_numeric($number) && ((int)$number>0);        
    }
}
