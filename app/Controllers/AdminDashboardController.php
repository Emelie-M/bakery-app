<?php

namespace App\Controllers;

use App\Domain\Models\AdminDashboardModel;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\SessionManager;

class AdminDashboardController extends BaseController
{
    public function __construct(Container $container, private AdminDashboardModel $admin_model)
    {
        parent::__construct($container);
    }

    public function dashboard(Request $request, Response $response, array $args): Response
    {
        //echo 'quack';exit;
        //* Step 1) Ask the shops model to fetch the list of shops for us.
        $products = $this->admin_model->getTotalProducts();
        $categories = $this->admin_model->getTotalCategories();
        //* Step 2) Prepare the data to be passed to the view.
        // You need to plan/know the structure in advance
        $data = [
            'title' => 'Admin Dashboard',
            'totalProducts' => $products,
            'totalCategories' => $categories,
            'username' => SessionManager::get('user_name', 'Admin')
        ];


        //* Step 2) Render the shops/listView
        return $this->render($response, 'admin/dashboardView.php', $data);
    }
}
