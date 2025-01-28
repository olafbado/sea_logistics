<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require '../includes/db.php';

$id = $_POST['id'] ?? null;

if ($id) {
    $stmt = $db->prepare("DELETE FROM orders WHERE ship_id = ?");
    $stmt->execute([$id]);

    $stmt = $db->prepare("DELETE FROM ships WHERE id = ?");
    $stmt->execute([$id]);

    $uploadDir = '../uploads/ships/' . $id . '/';
    $filePath = $uploadDir . 'ship.txt';

    if (file_exists($filePath)) {
        unlink($filePath);
    }

    if (is_dir($uploadDir)) {
        rmdir($uploadDir);
    }
}

header('Location: ../index.php?page=ships');
exit;
?>