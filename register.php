<?php
require 'includes/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username && $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $db->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
        $stmt->execute(['username' => $username, 'password' => $hashedPassword]);
        header('Location: login.php');
        exit;
    } else {
        $error = "Wszystkie pola są wymagane!";
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
</head>
<body>
<?php include 'includes/header.php'; ?>
<main>
    <h2>Rejestracja</h2>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST" class="register-form">
        <label for="username">Nazwa użytkownika:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Hasło:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Zarejestruj się</button>
    </form>
</main>
<?php include 'includes/footer.php'; ?>
</body>
</html>