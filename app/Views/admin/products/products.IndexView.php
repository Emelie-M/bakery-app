<?php

use App\Helpers\ViewHelper;

$title = $data['title'] ?? 'Admin Dashboard';
$products = $data['products'] ?? [];
ViewHelper::loadAdminHeader($title);
?>

<!-- TODO: Add an "Add Product" button/link that points to the create form -->
<a href="<?= APP_BASE_URL ?>/admin/products/create"
    class="btn btn-sm btn-success">
    Create Product
</a>
<br>
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= hs($product['id']) ?></td>
                    <td><?= hs($product['name']) ?></td>
                    <td><?= number_format((float) $product['price'], 2) ?></td>
                    <td><?= hs($product['stock_quantity']) ?></td>
                    <td><?= hs($product['created_at']) ?></td>
                    <td>
                        <a href="<?= APP_BASE_URL ?>/admin/products/<?= $product['id'] ?>/edit"
                            class="btn btn-sm btn-warning">
                            Edit
                        </a>
                        <form method="POST"
                            action="<?= APP_BASE_URL ?>/admin/products/<?= $product['id'] ?>/delete"
                            class="d-inline"
                            onsubmit="return confirm('Are you sure you want to delete this product?')">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php ViewHelper::loadAdminFooter(); ?>