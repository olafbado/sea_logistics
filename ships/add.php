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
    <title>Dodaj Statek</title>
</head>
<body>
    <h2>Dodaj Statek</h2>
    <form method="post">
        <label for="name">Nazwa:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="status">Status:</label>
        <input type="text" name="status" id="status" required>
        <br>
        <button type="submit">Dodaj</button>
    </form>
    <a href="../index.php?page=ships">Powrót</a>
</body>
</html>