<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Config\Database;
use App\Leads\LeadRepository;
use App\Leads\LeadService;

$db = new Database();
$repository = new LeadRepository($db);
$service = new LeadService($repository);

$leads = $service->fetchAllLeads(); // return array (not JSON)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Voice AI</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>

    <div class="dashboard">

        <aside class="sidebar">
            <div class="sidebar-logo">Voice AI</div>
            <nav class="sidebar-nav">
                <a href="#" class="active">Leads</a>
                <a href="#">Calls</a>
                <a href="#">Agents</a>
                <a href="#">Settings</a>
            </nav>
        </aside>

        <div class="dashboard-main">

            <header class="topbar">
                <h1>Leads</h1>
                <div class="topbar-user">
                    <span>Admin</span>
                    <div class="avatar">A</div>
                </div>
            </header>

            <main class="content">
                <div id="leads-container" class="leads-grid">

                    <?php if (empty($leads)): ?>

                        <div class="leads-empty">No leads yet.</div>

                    <?php else: ?>

                        <?php foreach ($leads as $lead): ?>
                            <div class="lead-card">
                                <div class="lead-card-name">
                                    <?= htmlspecialchars($lead['first_name']) ?>
                                </div>
                                <div class="lead-card-name">
                                    <?= htmlspecialchars($lead['last_name']) ?>
                                </div>
                                <div class="lead-card-meta">
                                    <?= htmlspecialchars($lead['phone_number']) ?>
                                </div>
                                <div class="lead-card-meta">
                                    <?= htmlspecialchars($lead['email'] ?? '') ?>
                                </div>
                                <div class="lead-card-footer">
                                    <button class="btn-call" data-lead-id="<?= (int) $lead['id'] ?>">
                                        Setup Call
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>
            </main>

        </div>
    </div>

</body>
</html>
