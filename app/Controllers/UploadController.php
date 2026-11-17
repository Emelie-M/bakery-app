<?php

namespace App\Controllers;

use App\Helpers\FileUploadHelper;
use App\Helpers\FlashMessage;
use App\Helpers\SessionManager;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\UploadedFileInterface;

class UploadController extends BaseController
{
    // TODO: Add a constructor that calls the parent constructor.
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }
    /**
     * Display the upload form (GET /admin/upload).
     */
    public function index(Request $request, Response $response, array $args): Response
    {
        // TODO: Render 'admin/upload/uploadView.php' with the title 'File Upload'
        $data = [
            'title' => 'File Upload'
        ];
        return $this->render($response, 'admin/upload/uploadView.php', $data);
    }

    /**
     * Process the upload form (POST /admin/upload).
     */
    public function upload(Request $request, Response $response, array $args): Response
    {
        // TODO: 1. Get the uploaded file named 'myfile' from the request.
        //          If there is none, set an error flash message using the FlashMessage
        //          helper class ("No file was received. It may be larger than the
        //          server allows.") and redirect to 'upload.index'.

        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['myfile'] ?? null;
        if ($uploadedFile === null) {
            FlashMessage::error("No file was received. It may be larger than the server allows.");
            return $this->redirect($request, $response, 'admin.upload.index');
        }

        // TODO: 2. Create the $config array (see the table below).
        $config = [
            'directory' => APP_UPLOADS_DIR . 'images/',
            'allowedTypes' => ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'],
            'maxSize' => 2 * 1024 * 1024,
            'filenamePrefix' => 'upload_'
        ];
        // TODO: 3. Upload the file using the FileUploadHelper class.
        $result = FileUploadHelper::upload($uploadedFile, $config);
        // TODO: 4. If the upload succeeded:
        //          - add the new filename to the 'uploaded_files' array in the session
        //          - set a success flash message using the FlashMessage helper class
        //       Otherwise, set an error flash message with the result's message.
        if ($result->isSuccess()) {
            $data = $result->getData();

            dd($data);
            $uploadedFiles = SessionManager::get('uploaded_files', []);

            $uploadedFiles[] = $data;

            SessionManager::set('uploaded_files', $uploadedFiles);

            FlashMessage::success($result->getMessage());
        } else {
            FlashMessage::error($result->getMessage());
        }
        // TODO: 5. Redirect to 'upload.index'
        return $this->redirect($request, $response, 'admin.upload.index');
    }
}
