<?php

use App\Helpers\SessionManager;
use App\Helpers\ViewHelper;

$title = $data['title'] ?? '';
ViewHelper::loadAdminHeader($title);

$uploadedFiles = SessionManager::get('uploaded_files', []);
?>

<div class="card mb-4">
    <div class="card-header">
        <h5>Upload an Image</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="<?= APP_BASE_URL ?>/admin/upload" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="myfile" class="form-label">Choose a file:</label>
                <input
                    type="file"
                    class="form-control"
                    id="myfile"
                    name="myfile"
                    accept="image/jpeg,image/png,image/gif"
                    required>
                <div class="form-text">
                    JPEG, PNG, or GIF, up to 2 MB.
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Upload File</button>
        </form>
    </div>
</div>

<?php if (!empty($uploadedFiles)): ?>
    <div class="card">
        <div class="card-header">
            <h5>Uploaded Files</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach (array_reverse($uploadedFiles) as $filename): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img
                                src="<?= APP_BASE_URL ?>/public/uploads/images/<?= hs($filename) ?>"
                                class="card-img-top"
                                alt="Uploaded image"
                                style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <p class="card-text small text-muted"><?= hs($filename) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php ViewHelper::loadAdminFooter(); ?>