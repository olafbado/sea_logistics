<?php
function getShips($db) {
    return $db->query("SELECT id, name FROM ships")->fetchAll(PDO::FETCH_ASSOC);
}

function redirectIfNotLoggedIn() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../login.php');
        exit;
    }
}