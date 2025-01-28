<?php
session_start();
require '../includes/functions.php';
require '../includes/db.php';

redirectIfNotLoggedIn();

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