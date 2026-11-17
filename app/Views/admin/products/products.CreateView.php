<?php

use App\Helpers\ViewHelper;

$title = $data['title'] ?? [];
ViewHelper::loadAdminHeader($title);
$categories = $data['categories'] ?? [];

?>

<form method="POST" action="<?= APP_BASE_URL ?>/admin/products">
    <!-- TODO: Add a select dropdown for category (required) -->
    <!--       Use ViewHelper::renderSelectOptions($categories, '', 'id', 'name') -->
    <!--       to generate the <option> elements -->


    <div class="form-field">
        <label for="category_id" class="form-label">Please select a category</label>
        <select class="form-control" name="category_id" required>
            <?= ViewHelper::renderSelectOptions($categories, '', 'id', 'name') ?>
        </select>
    </div>
    <br>
    <!-- TODO: Add input field for product name (text, required) -->
    <div class="form-field">
        <label for="name" class="form-label">Name</label>
        <textarea class="form-control" name="name" required></textarea>
    </div>
    <br>
    <!-- TODO: Add input field for price (number, step="0.01", required) -->
    <div class="form-field">
        <label for="price" class="form-label">Price</label>
        <textarea class="form-control" name="price" step="0.01" min="0" required></textarea>
    </div>
    <br>
    <!-- TODO: Add textarea for description (optional) -->
    <div class="form-field">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" name="description" rows="4"></textarea>
    </div>
    <!-- TODO: Add submit button -->
    <br>
    <button type="submit" class="btn btn-primary">Create Product</button>

    <!-- TODO: Add cancel link back to the admin product list -->
    <a href="<?= APP_BASE_URL ?>/admin/products" class="btn btn-secondary">Cancel</a>
</form>

<?php ViewHelper::loadAdminFooter(); ?>
