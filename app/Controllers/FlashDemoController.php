<?php

namespace App\Controllers;

use App\Helpers\FlashMessage;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\SessionManager;

class FlashDemoController extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        //echo 'quack';exit;
        //* Step 1) Ask the shops model to fetch the list of shops for us.
        //dd($cafes);
        //return $response;
        //* Step 2) Prepare the data to be passed to the view.
        // You need to plan/know the structure in advance
        $data = [
            'title' => 'Flash Message Demo',
            'username' => SessionManager::get('user_name', 'Admin')
        ];


        //* Step 2) Render the shops/listView
        return $this->render($response, "admin/flashDemoView.php", $data);
    }

    public function success(Request $request, Response $response, array $args): Response
    {
        FlashMessage::success('This is a success message!');


        //* Step 2) Render the shops/listView
        return $this->redirect($request, $response, 'admin.flash');
    }

    public function error(Request $request, Response $response, array $args): Response
    {
        FlashMessage::error('This is an error message!');


        //* Step 2) Render the shops/listView
        return $this->redirect($request, $response, 'admin.flash');
    }


    public function info(Request $request, Response $response, array $args): Response
    {
        FlashMessage::info('This is an info message!');


        //* Step 2) Render the shops/listView
        return $this->redirect($request, $response, 'admin.flash');
    }

    public function warning(Request $request, Response $response, array $args): Response
    {
        FlashMessage::warning('This is a warning message!');


        //* Step 2) Render the shops/listView
        return $this->redirect($request, $response, 'admin.flash');
    }

    public function multiple(Request $request, Response $response, array $args): Response
    {
        FlashMessage::success('This is a success message!');
        FlashMessage::error('This is an error message!');
        FlashMessage::warning('This is a warning message!');


        //* Step 2) Render the shops/listView
        return $this->redirect($request, $response, 'admin.flash');
    }

    public function clearMessages(Request $request, Response $response, array $args): Response
    {
        FlashMessage::success('This is a success message!');
        FlashMessage::error('This is an error message!');

        FlashMessage::clear();

        FlashMessage::info('Queued messages were cleared.');


        //* Step 2) Render the shops/listView
        return $this->redirect($request, $response, 'admin.flash');
    }
}
