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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $status = $_POST['status'];

    $stmt = $db->prepare("UPDATE ships SET name = ?, status = ? WHERE id = ?");
    $stmt->execute([$name, $status, $id]);

    header('Location: ../index.php?page=ships');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj Statek</title>
</head>
<body>
    <h2>Edytuj Statek</h2>
    <form method="post">
        <label for="name">Nazwa:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($ship['name']); ?>" required>
        <br>
        <label for="status">Status:</label>
        <input type="text" name="status" id="status" value="<?= htmlspecialchars($ship['status']); ?>" required>
        <br>
        <button type="submit">Zapisz</button>
    </form>
</body>
</html>