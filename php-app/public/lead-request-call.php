<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Leads\LeadService;

header('Content-Type: application/json');

$leadId = $_POST['leadId'] ?? null;

if (!$leadId) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing lead ID']);
    exit;
}

try {
    $service = new LeadService();
    $result  = $service->requestCall($leadId);
    echo json_encode(['ok' => true, 'express' => $result]);
} catch (\InvalidArgumentException $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
} catch (\Throwable $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
