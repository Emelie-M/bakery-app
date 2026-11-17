<?php

declare(strict_types=1);

/**
 * This file contains the routes for the web application.
 */

use App\Controllers\HomeController;
use App\Controllers\ShopsController;
use App\Controllers\AdminDashboardController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\SessionManager;
use App\Controllers\FlashDemoController;
use App\Controllers\ProductsController;
use App\Controllers\UploadController;
use App\Controllers\AuthController;
use App\Middleware\AuthMiddleware;
use App\Middleware\AdminAuthMiddleware;


return static function (Slim\App $app): void {
    $app->get('/register', [AuthController::class, 'register'])->setName('auth.register');
    $app->post('/register', [AuthController::class, 'store'])->setName('auth.store');
    $app->get('/login', [AuthController::class, 'login'])->setName('auth.login');

    $app->post('/login', [AuthController::class, 'authenticate'])->setName('auth.authenticate');
    $app->post('/logout', [AuthController::class, 'logout'])->setName('auth.logout');

    $app->get('/dashboard', [AuthController::class, 'dashboard'])
        ->setName('user.dashboard')
        ->add(AuthMiddleware::class);

    $app->get('/test-session', function ($request, $response) {
        // Get current counter, increment it
        $counter = SessionManager::get('counter', 0) + 1;
        SessionManager::set('counter', $counter);

        $response->getBody()->write("Counter: " . $counter);

        return $response;
    });

    //* GET /shops
    $app->get('/shops', [ShopsController::class, 'index'])->setName('shops.index');
    $app->get('/shops/{id}', [ShopsController::class, 'detailView'])->setName('shops.detailview');

    $app->group('/admin', function ($group) {

        $group->get('/flash', [FlashDemoController::class, 'index'])
            ->setName('admin.flash');
        $group->post('/flash/success', [FlashDemoController::class, 'success'])
            ->setName('admin.flash.success');
        $group->post('/flash/error', [FlashDemoController::class, 'error'])
            ->setName('admin.flash.error');
        $group->post('/flash/info', [FlashDemoController::class, 'info'])
            ->setName('admin.flash.info');
        $group->post('/flash/warning', [FlashDemoController::class, 'warning'])
            ->setName('admin.flash.warning');
        $group->post('/flash/multiple', [FlashDemoController::class, 'multiple'])
            ->setName('admin.flash.multiple');
        $group->post('/flash/clear', [FlashDemoController::class, 'clearMessages'])
            ->setName('admin.flash.clear');
        // Dashboard route
        $group->get('/dashboard', [AdminDashboardController::class, 'dashboard'])
            ->setName('admin.dashboard');

        // TODO (future labs): Add CRUD routes for products, categories, orders, users
        $group->get('/products', [ProductsController::class, 'index'])
            ->setName('admin.products.index');
        $group->get('/products/create', [ProductsController::class, 'create'])
            ->setName('admin.products.create');
        $group->post('/products', [ProductsController::class, 'store'])
            ->setName('admin.products.store');
        $group->get('/products/{id}/edit', [ProductsController::class, 'edit'])
            ->setName('admin.products.edit');
        $group->post('/products/{id}', [ProductsController::class, 'update'])
            ->setName('admin.products.store');
        $group->post('/products/{id}/delete', [ProductsController::class, 'delete'])->setName('admin.products.delete');
        $group->get('/upload', [UploadController::class, 'index'])->setName('admin.upload.index');
        $group->post('/upload', [UploadController::class, 'upload'])->setName('admin.upload.process');
        // $group->get('/categories', [CategoriesController::class, 'index'])
        //     ->setName('admin.categories.index');
        // $group->get('/orders', [OrdersController::class, 'index'])
        //     ->setName('admin.orders.index');
        // $group->get('/users', [UsersController::class, 'index'])
        //     ->setName('admin.users.index');
    })->add(AdminAuthMiddleware::class);


    //* NOTE: Route naming pattern: [controller_name].[method_name]
    $app->get('/', [HomeController::class, 'index'])
        ->setName('home.index');

    $app->get('/home', [HomeController::class, 'index'])
        ->setName('home.index');

    // A route to display PHP configuration information.
    $app->get('/phpinfo', function (Request $request, Response $response, $args) {
        ob_start();
        phpinfo();
        $phpinfo = ob_get_clean();
        $response->getBody()->write($phpinfo);
        return $response;
    });

    // A route to test runtime error handling and custom exceptions.
    $app->get('/error', function (Request $request, Response $response, $args) {
        throw new \Slim\Exception\HttpBadRequestException($request, "This is a runtime error. Something went wrong");
    });
};
