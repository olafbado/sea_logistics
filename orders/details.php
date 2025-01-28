<?php
session_start();
require '../includes/functions.php';
require '../includes/db.php';

redirectIfNotLoggedIn();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: ../index.php?page=orders');
    exit;
}

$stmt = $db->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    header('Location: ../index.php?page=orders');
    exit;
}

$fileContent = '';
if (!empty($order['file_path']) && file_exists($order['file_path'])) {
    $fileContent = file_get_contents($order['file_path']);
}

// Fetch the ship details
$shipStmt = $db->prepare("SELECT * FROM ships WHERE id = ?");
$shipStmt->execute([$order['ship_id']]);
$ship = $shipStmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Szczegóły zlecenia</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h1>Szczegóły zlecenia</h1>
        <p><strong>Tytuł:</strong> <?= htmlspecialchars($order['title']) ?></p>
        <p><strong>Opis:</strong> <?= htmlspecialchars($order['description']) ?></p>
        <?php if ($fileContent): ?>
            <p><strong>Zawartość pliku:</strong></p>
            <pre><?= htmlspecialchars($fileContent) ?></pre>
        <?php endif; ?>
        <?php if ($ship): ?>
            <p><strong>Statek:</strong> <?= htmlspecialchars($ship['name']) ?> (<?= htmlspecialchars($ship['status']) ?>)</p>
        <?php endif; ?>
        <a href="../index.php?page=orders">Powrót</a>
    </main>
</body>
</html>