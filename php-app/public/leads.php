<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Leads\LeadService;

$service = new LeadService();

header('Content-Type: application/json');

$leads = $service->fetchAllLeads();
echo $leads;
