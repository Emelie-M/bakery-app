<?php

namespace App\Controllers;

use App\Domain\Models\ProductsModel;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\FlashMessage;
use App\Helpers\FileUploadHelper;
use Psr\Http\Message\UploadedFileInterface;

class ProductsController extends BaseController
{
    public function __construct(
        Container $container,
        private ProductsModel $productsModel
    ) {
        parent::__construct($container);
    }

    /**
     * Display the list of all products.
     */
    public function index(Request $request, Response $response, array $args): Response
    {
        // TODO: 1. Fetch all products using $this->productsModel->getAll()
        $products = $this->productsModel->getAll();
        // TODO: 2. Create a $data array with 'title' and 'products' keys
        $data = [
            'title' => 'Admin Dashboard',
            'products' => $products
        ];
        // TODO: 3. Render the view 'admin/products/products.IndexView.php' and pass $data
        return $this->render($response, 'admin/products/products.IndexView.php', $data);
    }

    public function create(Request $request, Response $response, array $args): Response
    {
        // TODO: 1. Fetch all categories using $this->productsModel->getAllCategories()
        $categories = $this->productsModel->getAllCategories();
        // TODO: 2. Create a $data array with 'title', and 'categories' keys
        $data = [
            'title' => 'Admin Dashboard',
            'categories' => $categories
        ];
        // TODO: 3. Render the view 'admin/products/products.CreateView.php' and pass $data
        return $this->render($response, 'admin/products/products.CreateView.php', $data);
    }

    public function store(Request $request, Response $response, array $args): Response
    {


        // TODO: 1. Get form data using $request->getParsedBody()
        $data = $request->getParsedBody();
        // TODO: 2. Validate required fields (name and price)
        //       - If validation fails, set an error flash message using the FlashMessage helper class
        //         and redirect back to 'products.create'
        $name = trim($data['name'] ?? '');
        $price = $data['price'] ?? '';

        if ($name === '' || $price === '' || !is_numeric($price) || $price < 0) {
            FlashMessage::error('Product name or price is invalid!');

            return $this->redirect($request, $response, 'admin.products.create');
        }
        // TODO: 3. Save to database using $this->productsModel->createAndGetId()


        $dbdata = [
            'category_id' => $data['category_id'],
            'name' => $name,
            'price' => $price,
            'description' => $data['description']
        ];
        $id = $this->productsModel->createAndGetId($dbdata);
        // TODO: 4. Set a success flash message using the FlashMessage helper class
        FlashMessage::success('Product successfully created!');
        // TODO: 5. Redirect to the product list ('products.index')
        return $this->redirect($request, $response, 'admin.products.index');
    }

    public function edit(Request $request, Response $response, array $args): Response
    {
        // TODO: 1. Get the product ID from the route arguments
        $id = $args['id'];
        // TODO: 2. Fetch the product
        $product = $this->productsModel->findById($id);
        // TODO: 3. If product not found, set an error flash message using the FlashMessage helper class
        //          and redirect to 'products.index'
        if ($product === false) {
            FlashMessage::error('Product not found!');
            return $this->redirect($request, $response, 'admin.products.index');
        }
        // TODO: 4. Fetch all categories
        $categories = $this->productsModel->getAllCategories();
        // TODO: 5. Create a $data array with 'title', 'product', and 'categories' keys
        $data = [
            'title' => "Product {$id}",
            'product' => $product,
            'categories' => $categories,
            'image' => $this->productsModel->getPrimaryImage($id)
        ];
        // TODO: 6. Render the view 'admin/products/products.EditView.php' and pass $data
        return $this->render($response, 'admin/products/products.EditView.php', $data);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        // TODO: 1. Get the product ID from the route arguments
        $id = $args['id'];
        // TODO: 2. Get the submitted form data
        $data = $request->getParsedBody();
        // TODO: 3. Validate required fields (name and price)
        //       - If validation fails, set an error flash message using the FlashMessage helper class
        //         and redirect back to 'products.edit'
        $name = trim($data['name'] ?? '');
        $price = $data['price'] ?? '';

        if ($name === '' || $price === '' || !is_numeric($price) || $price < 0) {
            FlashMessage::error('Product name or price is invalid!');

            return $this->redirect($request, $response, 'admin.products.edit');
        }
        // TODO: 4. Update the product
        $count = $this->productsModel->update($id, $data);
        // TODO: 5. Set a success flash message using the FlashMessage helper class
        FlashMessage::success("{$count} Product(s) successfully updated!");
        // TODO: 6. Redirect to the product list ('products.index')
        return $this->redirect($request, $response, 'admin.products.index');
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        // TODO: 1. Get the product ID from the route arguments
        $id = $args['id'];
        // TODO: 2. Delete the product
        $this->productsModel->delete($id);
        // TODO: 3. Set a success flash message using the FlashMessage helper class
        FlashMessage::success("Successfully deleted product {$id}!");
        // TODO: 4. Redirect to the product list ('products.index')
        return $this->redirect($request, $response, 'admin.products.index');
    }

    /**
     * Upload a new image for a product (POST /admin/products/{id}/image).
     */
    public function uploadImage(Request $request, Response $response, array $args): Response
    {
        // TODO: 1. Get the product ID from the route arguments.
        //          If the product does not exist, set an error flash message using the
        //          FlashMessage helper class and redirect to 'products.index'.
        $productId = $args['id'];
        if (!$this->productsModel->findById($productId)) {
            FlashMessage::error('Product ID invalid!');
            return $this->redirect($request, $response, 'admin.products.index');
        }

        // TODO: 2. Get the uploaded file named 'image' from the request.
        //          If there is none, set an error flash message using the FlashMessage
        //          helper class and redirect back to 'products.edit'.


        // TODO: 3. Upload the file using the FileUploadHelper class, with the same
        //          configuration as in Step 5 except:
        //          - 'directory' => APP_BASE_DIR_PATH . '/public/uploads/products'
        //          - 'filenamePrefix' => 'product_'

        // TODO: 4. If the upload succeeded:
        //          - save 'uploads/products/' followed by the new filename as the
        //            product's primary image
        //          - set a success flash message using the FlashMessage helper class
        //       Otherwise, set an error flash message with the result's message.

        // TODO: 5. Redirect back to 'products.edit' for this product.
    }
}
