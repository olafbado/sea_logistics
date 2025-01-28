<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $status = $_POST['status'];

    $stmt = $db->prepare("INSERT INTO ships (name, status) VALUES (?, ?)");
    $stmt->execute([$name, $status]);
    header('Location: ../index.php?page=ships');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj statek</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h1>Dodaj statek</h1>
        <form method="POST" class="ship-form">
            <label for="name">Nazwa:</label>
            <input type="text" name="name" placeholder="Nazwa statku" required>
            <br>
            <label for="status">Status:</label>
            <input type="text" name="status" placeholder="Status statku" required>
            <br>
            <button type="submit">Dodaj</button>
        </form>
        <a href="../index.php?page=ships">Powrót</a>
    </main>
</body>
</html>