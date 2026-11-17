<?php

use App\Helpers\ViewHelper;

$title = $data['title'] ?? [];
ViewHelper::loadAdminHeader($title);
$categories = $data['categories'] ?? [];
$product = $data['product'][0] ?? [];
//dd($product);

ViewHelper::loadAdminHeader($title);
?>

<form method="POST" action="<?= APP_BASE_URL ?>/admin/products/<?= $product['id'] ?>">
    <!-- TODO: Add a select dropdown for category (pre-select the product's current category) -->
    <!--       Use ViewHelper::renderSelectOptions($categories, $product['category_id'], 'id', 'name') -->
    <div class="form-field">
        <label for="category_id" class="form-label">Please select a category</label>
        <select class="form-control" name="category_id" required>
            <?= ViewHelper::renderSelectOptions($categories, $product['category_id'], 'id', 'name') ?>
        </select>
    </div>
    <br>
    <!-- TODO: Add input field for product name (pre-populated with $product['name']) -->
    <div class="form-field">
        <label for="name" class="form-label">Name</label>
        <textarea class="form-control" name="name" required><?= $product['name'] ?></textarea>
    </div>
    <br>
    <!-- TODO: Add input field for price (pre-populated with $product['price']) -->
    <div class="form-field">
        <label for="price" class="form-label">Price</label>
        <textarea class="form-control" name="price" step="0.01" min="0" required><?= $product['price'] ?></textarea>
    </div>
    <br>
    <!-- TODO: Add textarea for description (pre-populated with $product['description']) -->
    <div class="form-field">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" name="description" rows="4"><?= $product['description'] ?></textarea>
    </div>
    <!-- TODO: Add submit button ("Update Product") -->
    <br>
    <button type="submit" class="btn btn-primary">Update Product</button>
    <!-- TODO: Add cancel link back to the admin product list -->
    <a href="<?= APP_BASE_URL ?>/admin/products" class="btn btn-secondary">Cancel</a>
</form>

<?php ViewHelper::loadAdminFooter(); ?>
