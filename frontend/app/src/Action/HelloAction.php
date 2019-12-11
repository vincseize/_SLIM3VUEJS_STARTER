<?php
namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class HelloAction
{
    private $view;
    private $logger;

    public function __construct(Twig $view, LoggerInterface $logger)
    {
        $this->view = $view;
        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $this->logger->info("Hello page action dispatched");
        

        $viewData = [
            'now' => date('Y-m-d H:i:s'),
            'hello' => 'hella'
        ];
    
        // return $this->get(Twig::class)->render($response, 'time.twig', $viewData);

        $this->view->render($response, 'hello.twig', $viewData);
        return $response;
    }
}
