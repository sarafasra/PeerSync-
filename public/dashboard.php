<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../src/Repositories/HelpRequestRepository.php';

use Config\Database; 
use Src\Repositories\HelpRequestRepository;
 
$pdo = Database::getInstance();

$requestRepo = new HelpRequestRepository();
 
$requests = $requestRepo->findAll(); 

 
$userName = $_SESSION['user_name'] ?? 'Guest';

$totalUsers = $pdo->query(" 
    SELECT COUNT(*) FROM users
")->fetchColumn(); 

$totalRequests = $pdo->query("
    SELECT COUNT(*) FROM help_requests
")->fetchColumn();

$pendingRequests = $pdo->query("
    SELECT COUNT(*) 
    FROM help_requests 
    WHERE statut = 'EN_ATTENTE'
")->fetchColumn();

$doneRequests = $pdo->query("
    SELECT COUNT(*) 
    FROM help_requests 
    WHERE statut = 'RESOLUE'
")->fetchColumn();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PeerSync Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<!-- NAVBAR -->

<nav class="navbar navbar-dark bg-dark px-4">

    <span class="navbar-brand">
        PeerSync
    </span>

    <span class="text-white">
        Welcome, <?= htmlspecialchars($userName) ?>
    </span>

</nav>

<div class="container mt-5">

    <h2 class="mb-4">
        Dashboard
    </h2>

    <!-- CARDS -->

    <div class="row">

        <div class="col-md-3">

            <div class="card text-white bg-primary mb-3">

                <div class="card-body">

                    <h5>Total Users</h5>

                    <h3><?= $totalUsers ?></h3>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card text-white bg-success mb-3">

                <div class="card-body">

                    <h5>Total Requests</h5>

                    <h3><?= $totalRequests ?></h3>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card text-white bg-warning mb-3">

                <div class="card-body">

                    <h5>Pending</h5>

                    <h3><?= $pendingRequests ?></h3>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card text-white bg-dark mb-3">

                <div class="card-body">

                    <h5>Done</h5>

                    <h3><?= $doneRequests ?></h3>

                </div>

            </div>

        </div>

    </div>

    <!-- ACTIONS -->

    <div class="mb-5">

        <a href="create_request.php"
           class="btn btn-primary">

            Create Request

        </a>

    </div>

    <!-- REQUESTS LIST -->

    <h3 class="mb-4">
        Help Requests
    </h3>

    <?php foreach($requests as $request): ?>

        <div class="card mb-3 shadow-sm">

            <div class="card-body">

                <h5 class="card-title">
                    <?= htmlspecialchars($request['titre']) ?>
                </h5>

                <p class="card-text">
                    <?= htmlspecialchars($request['description']) ?>
                </p>

                <p>
                    <strong>Technologie:</strong>
                    <?= htmlspecialchars($request['technologie']) ?>
                </p>

                <p>
                    <strong>Status:</strong>
                    <?= htmlspecialchars($request['statut']) ?>
                </p>

                <!-- TAKE REQUEST BUTTON -->

                <?php if($request['statut'] === 'EN_ATTENTE'): ?>

                    <form action="../scripts/assign_process.php"
                          method="POST">

                        <input type="hidden"
                               name="request_id"
                               value="<?= $request['id'] ?>">

                        <button class="btn btn-success">

                            Take Request

                        </button>

                    </form>

                <?php endif; ?>

            </div>

        </div>

    <?php endforeach; ?>

</div>

</body>
</html>