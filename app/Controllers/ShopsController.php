<?php

namespace App\Controllers;

use App\Domain\Models\ShopsModel;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ShopsController extends BaseController
{

    public function __construct(Container $container, private ShopsModel $shops_model)
    {
        parent::__construct($container);
    }
    //*NOTE: General methods: for validation, date formation, etc.
    // 2) Callback methods / like an even handler: are the methods used for handling HTTP requests.
    //! To name a callback method: You can use a prefix, such as handle*
    //! Like handleGetShops
    //? OR, standard callback names: index


    /**
     * Gets the list of available shops from the brew_finder DB.
     * ROUTE: /shops
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function index(Request $request, Response $response, array $args): Response
    {
        //echo 'quack';exit;
        //* Step 1) Ask the shops model to fetch the list of shops for us.
        $cafes = $this->shops_model->getAllCafes();
        //dd($cafes);
        //return $response;
        //* Step 2) Prepare the data to be passed to the view.
        // You need to plan/know the structure in advance
        $data = [
            'page_title' => "List of shops in Quebec!",
            'cafes' => $cafes
        ];


        //* Step 2) Render the shops/listView
        return $this->render($response, "shops/listView.php", $data);
    }

    public function detailView(Request $request, Response $response, array $args): Response
    {
        //echo 'quack';exit;
        //* Step 1) Ask the shops model to fetch the list of shops for us.
        $id = $args['id'];
        $cafe = $this->shops_model->getCafeByID($id);
        //dd($cafes);
        //return $response;
        //* Step 2) Prepare the data to be passed to the view.
        // You need to plan/know the structure in advance
        $data = [
            'page_title' => "Cafe {$id}",
            'cafe' => $cafe
        ];


        //* Step 2) Render the shops/listView
        return $this->render($response, "shops/show.php", $data);
    }
}
