<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require '../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: ../index.php?page=ships');
    exit;
}

$stmt = $db->prepare("SELECT * FROM ships WHERE id = ?");
$stmt->execute([$id]);
$ship = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$ship) {
    header('Location: ../index.php?page=ships');
    exit;
}

$orderStmt = $db->prepare("SELECT COUNT(*) FROM orders WHERE ship_id = ?");
$orderStmt->execute([$id]);
$orderCount = $orderStmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Szczegóły statku</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h1>Szczegóły statku</h1>
        <p><strong>Nazwa:</strong> <?= htmlspecialchars($ship['name']) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($ship['status']) ?></p>
        <p><strong>Liczba zleceń:</strong> <?= $orderCount ?></p>
        <a href="../index.php?page=ships">Powrót</a>
    </main>
</body>
</html>