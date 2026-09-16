<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Config\Database;

try {
    $pdo = Database::connect();
    echo "Connected successfully!";
} catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}
