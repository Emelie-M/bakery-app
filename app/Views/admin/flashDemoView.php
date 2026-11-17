<?php

use App\Helpers\ViewHelper;
$title = $title ?? 'Admin Dashboard';
$username = $username ?? 'Admin';
ViewHelper::loadAdminHeader($title, $username);
?>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Test Flash Messages</h5>
    </div>
    <div class="card-body">
        <p class="card-text">Click the buttons below to test different types of flash messages:</p>

        <div class="d-grid gap-2">
            <form method="POST" action="<?= APP_BASE_URL ?>/admin/flash/success">
                <button type="submit" class="btn btn-success w-100">Show Success Message</button>
            </form>

            <form method="POST" action="<?= APP_BASE_URL ?>/admin/flash/error">
                <button type="submit" class="btn btn-danger w-100">Show Error Message</button>
            </form>

            <form method="POST" action="<?= APP_BASE_URL ?>/admin/flash/info">
                <button type="submit" class="btn btn-info w-100">Show Info Message</button>
            </form>

            <form method="POST" action="<?= APP_BASE_URL ?>/admin/flash/warning">
                <button type="submit" class="btn btn-warning w-100">Show Warning Message</button>
            </form>

            <form method="POST" action="<?= APP_BASE_URL ?>/admin/flash/multiple">
                <button type="submit" class="btn btn-primary w-100">Show Multiple Messages</button>
            </form>

            <form method="POST" action="<?= APP_BASE_URL ?>/admin/flash/clear">
                <button type="submit" class="btn btn-secondary w-100">Clear Queued Messages</button>
            </form>
        </div>
    </div>
</div>

<?php ViewHelper::loadAdminFooter(); ?>
