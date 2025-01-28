<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport System</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <header>
        <h1>Sea Logistics</h1>
        <nav class="flex">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="index.php">Strona główna</a>
                <a href="logout.php">Wyloguj się</a>
                <a href="index.php?page=orders">List Zleceń</a>
                <a href="index.php?page=ships">List Statków</a>
                <a href="orders/add.php">Dodaj Zlecenie</a>
                <a href="ships/add.php">Dodaj Statek</a>
            <?php else: ?>
                <a href="login.php">Logowanie</a>
                <a href="register.php">Rejestracja</a>
            <?php endif; ?>
        </nav>
    </header>