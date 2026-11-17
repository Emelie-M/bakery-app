<?php

use App\Helpers\ViewHelper;

$title = $data['title'] ?? 'Admin Dashboard';
$username = $data['username'] ?? 'Admin';
$totalProducts = $data['totalProducts'] ?? 0;
$totalCategories = $data['totalCategories'] ?? 0;

ViewHelper::loadAdminHeader($title, $username);
?>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card border-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Products</h6>
                        <h3 class="mb-0"><?= htmlspecialchars($totalProducts) ?></h3>
                    </div>
                    <div class="text-primary fs-1">&#128230;</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card border-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Categories</h6>
                        <h3 class="mb-0"><?= htmlspecialchars($totalCategories) ?></h3>
                    </div>
                    <div class="text-warning fs-1">&#128193;</div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ViewHelper::loadAdminFooter(); ?>
