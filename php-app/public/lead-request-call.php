<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Leads\LeadService;

$service = new LeadService();

$leadId = $_POST['leadId'] ?? null;

if (!$leadId) {
    header('Location: dashboard.php?error=Missing lead ID');
    exit;
}

try {
    $service->requestCall($leadId);

    header('Location: dashboard.php');
    exit;
} catch (\InvalidArgumentException $e) {
    $errorMessage = urlencode($e->getMessage());

    header("Location: dashboard.php?error=$errorMessage");
    exit;
}
