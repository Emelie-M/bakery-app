<?php

namespace App\Helpers;

use App\Helpers\Core\Result;
use finfo;
use Psr\Http\Message\UploadedFileInterface;
use RuntimeException;
use App\Helpers\FlashMessage;

class FileUploadHelper
{
    /**
     * Validate an uploaded file, save it under a random name, and return a Result.
     *
     * @param UploadedFileInterface $uploadedFile The uploaded file from the request
     * @param array $config Configuration options:
     *   - 'directory' (string): Absolute path of the upload directory (required)
     *   - 'allowedTypes' (array): Allowed media types mapped to the extension
     *     to save them with, e.g. ['image/jpeg' => 'jpg'] (required)
     *   - 'maxSize' (int): Maximum file size in bytes (required)
     *   - 'filenamePrefix' (string): Prefix for generated filenames (default: 'upload_')
     * @return Result Success with ['filename' => ...], or failure with an error message
     */
    public static function upload(UploadedFileInterface $uploadedFile, array $config): Result
    {
        // TODO: 1. Read the four configuration values from $config, using the defaults above.
        //          If 'directory' or 'allowedTypes' is empty, or 'maxSize' is 0 or less,
        //          return a failure.
        $directory = $config['directory'] ?? APP_UPLOADS_DIR;
        $allowedTypes = $config['allowedTypes'] ?? [];
        $maxSize = $config['maxSize'] ?? 256;
        $filenamePrefix = $config['filenamePrefix'] ?? '';
        // TODO: 2. Check the file's upload error code (see the table below).
        $errorCode = $uploadedFile->getError();
        if ($errorCode !== UPLOAD_ERR_OK) {
            return Result::failure('File upload failed! Error code:' . $errorCode);
        }

        // TODO: 3. Check that the file is not larger than the maximum size.
        $size = round($uploadedFile->getSize() / (1024 * 1024), 1);
        if ($size > $maxSize) {
            return Result::failure('File upload failed! The file size exceeds the maximum!');
        }
        // TODO: 4. Detect the file's real media type from its content, and check
        //          that it is one of the allowed types.
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $detectedType = $finfo->file($uploadedFile->getStream()->getMetadata('uri'));
        // TODO: 5. Generate a random filename: the prefix, 32 random hexadecimal
        //          characters, a dot, and the extension mapped to the detected type.
        $file_extension = $config['allowedTypes'][$detectedType] ?? null;
        if (is_null($file_extension)) {
            return Result::failure("Couldn't  resolve the file extension based on the file content.");
        }
        $fileName = $filenamePrefix . bin2hex(random_bytes(16)) . '.' . $file_extension;
        // TODO: 6. Create the upload directory if it does not exist.
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        // TODO: 7. Move the file into the upload directory under the new name.
        //          If moving fails, return a failure.

        try {
            // dd($directory . $fileName);
            $uploadedFile->moveTo($directory . $fileName);
        } catch (RuntimeException $e) {
            return Result::failure('Failed to move file: ' . $e->getMessage());
        }
        // TODO: 8. Return a success with the new filename in the data.
        return Result::success("File successfully uploaded!", $fileName);
    }
}
