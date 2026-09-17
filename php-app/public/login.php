<?php

use App\Admins\AdminService;

require __DIR__ . '/../vendor/autoload.php';

$service = new AdminService();

try {
    $service->handleAdminLogin($_POST);
    header('Location: dashboard.php?success=1');
    exit;
} catch (\InvalidArgumentException $e) {
    $errorMessage = urlencode($e->getMessage());
    header("Location: login-form.php?error=$errorMessage");
    exit;
}
