<?php
session_start();
require '../includes/functions.php';
require '../includes/db.php';

redirectIfNotLoggedIn();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: ../index.php?page=ships');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $status = $_POST['status'];

    $stmt = $db->prepare("UPDATE ships SET name = ?, status = ? WHERE id = ?");
    $stmt->execute([$name, $status, $id]);
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
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj statek</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h1>Edytuj statek</h1>
        <form method="POST" class="ship-form">
            <label for="name">Nazwa:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($ship['name']) ?>" required>
            <br>
            <label for="status">Status:</label>
            <input type="text" name="status" value="<?= htmlspecialchars($ship['status']) ?>" required>
            <br>
            <button type="submit">Zapisz zmiany</button>
        </form>
        <a href="../index.php?page=ships">Powrót</a>
    </main>
</body>
</html>