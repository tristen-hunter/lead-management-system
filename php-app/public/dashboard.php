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
                              <div class="lead-card-main">
                                  <div class="lead-card-name">
                                      <?= htmlspecialchars($lead['first_name'] . ' ' . $lead['last_name']) ?>
                                  </div>
                                  <div class="lead-card-id">
                                      ID: <?= htmlspecialchars($lead['id']) ?>
                                  </div>

                                  <div class="lead-card-details">
                                      <div class="lead-card-detail">
                                          <span class="lead-card-detail-label">Phone</span>
                                          <span class="lead-card-detail-value">
                                              <?= htmlspecialchars($lead['phone_number']) ?>
                                          </span>
                                      </div>

                                      <div class="lead-card-detail">
                                          <span class="lead-card-detail-label">Email</span>
                                          <span class="lead-card-detail-value">
                                              <?= htmlspecialchars($lead['email']) ?>
                                          </span>
                                      </div>

                                      <div class="lead-card-detail">
                                          <span class="lead-card-detail-label">Captured</span>
                                          <span class="lead-card-detail-value">
                                              <?= htmlspecialchars(
                                                  date('d M Y, H:i', strtotime($lead['created_at'])),
                                              ) ?>
                                          </span>
                                      </div>
                                  </div>
                              </div>

                              <div class="lead-card-footer">
                                  <button class="btn-call" data-lead-id="<?= htmlspecialchars($lead['id']) ?>">
                                      Start Call
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
