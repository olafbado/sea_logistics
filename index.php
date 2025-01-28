<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Zarządzania</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main>
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 'orders';
        switch ($page) {
            case 'ships':
                include 'ships/list.php';
                break;
            case 'orders':
            default:
                include 'orders/list.php';
                break;
        }
        ?>
    </main>
</body>
</html>