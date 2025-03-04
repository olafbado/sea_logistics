<?php
session_start();
require '../includes/functions.php';
require '../includes/db.php';

redirectIfNotLoggedIn();

$id = $_POST['id'] ?? null;

if ($id) {
    $stmt = $db->prepare("SELECT file_path FROM orders WHERE id = ?");
    $stmt->execute([$id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($order) {
        $stmt = $db->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->execute([$id]);

        $filePath = $order['file_path'];

        if ($filePath && file_exists($filePath)) {
            unlink($filePath);
        }

        $uploadDir = dirname($filePath);
        if (is_dir($uploadDir) && count(scandir($uploadDir)) == 2) {
            rmdir($uploadDir);
        }
    }
}

header('Location: ../index.php?page=orders');
exit;
?>