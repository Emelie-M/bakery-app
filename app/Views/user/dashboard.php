<?php

use App\Helpers\SessionManager;
use App\Helpers\ViewHelper;

$title = $data['title'] ?? 'Dashboard';
ViewHelper::loadHeader($title);
?>

<h1>User Dashboard</h1>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">My Profile</h5>
                <p class="card-text">
                    <strong>Name:</strong> <?= hs(SessionManager::get('user_name', 'N/A')) ?><br>
                    <strong>Email:</strong> <?= hs(SessionManager::get('user_email', 'N/A')) ?><br>
                    <strong>Role:</strong> <?= hs(SessionManager::get('user_role', 'N/A')) ?>
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Quick Actions</h5>
                <div class="d-grid gap-2">
                    <a href="<?= APP_BASE_URL ?>/" class="btn btn-primary">Browse Products</a>
                    <form method="POST" action="<?= APP_BASE_URL ?>/logout">
                        <button type="submit" class="btn btn-outline-secondary w-100">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ViewHelper::loadFooter(); ?>
