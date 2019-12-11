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


        $viewData = [
            'text1' => 'page processing : by twig',
            'text2' => 'this text is a variable too from '. basename(__FILE__)
        ];

        // get all result
        // $this->get('/api/clients2', function ($request, $response, $args) {
        //     $sth = $this->db->prepare("SELECT * FROM clients ORDER BY id");
        // $sth->execute();
        // $result = $sth->fetchAll();
        // return $this->response->withJson($result);
        // });


        $this->view->render($response, 'home.twig', $viewData);
        return $response;
    }
}


