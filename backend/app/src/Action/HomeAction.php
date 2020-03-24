<?php

namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class HomeAction
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
        $this->logger->info("Home page action dispatched");

        $dir = APP_DIR . 'src/Action/';

        $viewData = [
            'text1' => 'Page processing by Twig',
            'text2' => 'This text is a variable too, from <code>' . $dir . basename(__FILE__) . '</code>'
        ];

        $this->view->render($response, 'home.twig', $viewData);
        return $response;
    }
}
