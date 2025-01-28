<?php
require '../includes/db.php';
require '../includes/functions.php';

session_start();

redirectIfNotLoggedIn();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $ship_id = $_POST['ship_id'];
    $fileContent = $_POST['file_content'];
    $filePath = null;

    $uploadDir = '../uploads/orders/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!empty($fileContent)) {
        $filePath = $uploadDir . uniqid() . '.txt';
        file_put_contents($filePath, $fileContent);
    } elseif (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $filePath = $uploadDir . basename($_FILES['file']['name']);
        move_uploaded_file($_FILES['file']['tmp_name'], $filePath);
    }

    $stmt = $db->prepare("INSERT INTO orders (title, description, file_path, ship_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$title, $description, $filePath, $ship_id]);
    header('Location: ../index.php?page=orders');
    exit;
}


$ships =getShips($db);

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj zlecenie</title>
    <link rel="stylesheet" href="../assets/styles.css">
    <script>
        function toggleInputMethod() {
            const method = document.querySelector('input[name="input_method"]:checked').value;
            document.getElementById('file_input').style.display = method === 'file' ? 'block' : 'none';
            document.getElementById('textarea_input').style.display = method === 'textarea' ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h1>Dodaj zlecenie</h1>
        <form method="POST" enctype="multipart/form-data" class="order-form">
            <label for="title">Tytuł:</label>
            <input type="text" name="title" placeholder="Tytuł zlecenia" required>
            <br>
            <label for="description">Opis:</label>
            <textarea name="description" placeholder="Opis zlecenia" required></textarea>
            <br>
            <label for="ship_id">Statek:</label>
            <select name="ship_id" required>
                <option value="">Wybierz statek</option>
                <?php foreach ($ships as $ship): ?>
                    <option value="<?= $ship['id'] ?>"><?= htmlspecialchars($ship['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <label>Wybierz metodę wprowadzenia pliku:</label>
            <div class="input-method">
                <input type="radio" name="input_method" value="textarea" id="textarea_method" onclick="toggleInputMethod()" checked>
                <label for="textarea_method">Wprowadź zawartość pliku</label>
                <input type="radio" name="input_method" value="file" id="file_method" onclick="toggleInputMethod()">
                <label for="file_method">Prześlij plik .txt</label>
            </div>
            <div id="textarea_input">
                <label for="file_content">Zawartość pliku:</label>
                <textarea name="file_content" rows="10" cols="50" placeholder="Wpisz zawartość pliku tutaj"></textarea>
            </div>
            <div id="file_input" style="display: none;">
                <label for="file">Wybierz plik .txt:</label>
                <input type="file" name="file" accept=".txt">
            </div>
            <br>
            <button type="submit">Dodaj</button>
        </form>
        <a href="../index.php?page=orders">Powrót</a>
    </main>
</body>
</html>