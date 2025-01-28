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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $ship_id = $_POST['ship_id'];
    $fileContent = $_POST['file_content'];

    $uploadDir = '../uploads/orders/' . $id . '/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $filePath = $uploadDir . 'order.txt';
    file_put_contents($filePath, $fileContent);

    $stmt = $db->prepare("UPDATE orders SET title = ?, description = ?, file_path = ?, ship_id = ? WHERE id = ?");
    $stmt->execute([$title, $description, $filePath, $ship_id, $id]);
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

// Fetch the list of ships
$ships = $db->query("SELECT id, name FROM ships")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj zlecenie</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h1>Edytuj zlecenie</h1>
        <form method="POST" class="order-form">
            <label for="title">Tytuł:</label>
            <input type="text" name="title" value="<?= htmlspecialchars($order['title']) ?>" required>
            <br>
            <label for="description">Opis:</label>
            <textarea name="description" required><?= htmlspecialchars($order['description']) ?></textarea>
            <br>
            <label for="ship_id">Statek:</label>
            <select name="ship_id" required>
                <option value="">Wybierz statek</option>
                <?php foreach ($ships as $ship): ?>
                    <option value="<?= $ship['id'] ?>" <?= $ship['id'] == $order['ship_id'] ? 'selected' : '' ?>><?= htmlspecialchars($ship['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <label for="file_content">Zawartość pliku:</label>
            <textarea name="file_content" rows="10" cols="50"><?= htmlspecialchars($fileContent) ?></textarea>
            <br>
            <button type="submit">Zapisz zmiany</button>
        </form>
        <a href="../index.php?page=orders">Powrót</a>
    </main>
</body>
</html>