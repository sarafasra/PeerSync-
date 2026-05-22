<?php

session_start();

require_once __DIR__ . '/../config/Database.php';

use Config\Database;

$pdo = Database::getInstance();

// check login (optional but good)
$userId = $_SESSION['user_id'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titre = $_POST['titre'] ?? '';
    $description = $_POST['description'] ?? '';
    $technologie = $_POST['technologie'] ?? '';

    if (!empty($titre) && !empty($description) && !empty($technologie)) {

        $stmt = $pdo->prepare("
            INSERT INTO help_requests 
            (titre, description, technologie, statut, id_student, id_tutor)
            VALUES (?, ?, ?, 'EN_ATTENTE', ?, NULL)
        ");

        $stmt->execute([
            $titre,
            $description,
            $technologie,
            $userId
        ]);

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h2>Create Help Request</h2>

    <?php if (!empty($error)) : ?>
        <div class="alert alert-danger">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="titre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Technology</label>
            <input type="text" name="technologie" class="form-control" required>
        </div>

        <button class="btn btn-primary">Create Request</button>

        <a href="dashboard.php" class="btn btn-secondary">Back</a>

    </form>

</div>

</body>
</html>