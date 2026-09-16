<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Leads\LeadService;

$service = new LeadService();
$leadId = $service->captureLead($_POST);

echo "Lead created with ID: " . $leadId;
