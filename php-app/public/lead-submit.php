<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Leads\LeadService;

$service = new LeadService();

try {
    $service->captureLead($_POST);
    header('Location: index.php?success=1');
    exit;
} catch (\InvalidArgumentException $e) {
    $errorMessage = urlencode($e->getMessage());
    header("Location: lead-form.php?error=$errorMessage");
    exit;
}
