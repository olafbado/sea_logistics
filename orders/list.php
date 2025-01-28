<?php
require 'includes/db.php';

$search = $_GET['search'] ?? '';

$stmt = $db->prepare("SELECT * FROM orders WHERE title LIKE ?");
$stmt->execute(['%' . $search . '%']);

echo '<h2>Lista Zleceń</h2>';
$action = 'index.php?page=orders';
include 'includes/search.php';
echo '<table border="1">';
echo '<tr><th>Tytuł</th><th>Akcje</th></tr>';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td>' . $row['title'] . '</td>';
    echo '<td>
            <a href="orders/details.php?id=' . $row['id'] . '">Szczegóły</a>
            <a href="orders/edit.php?id=' . $row['id'] . '">Edytuj</a>
            <form method="post" action="orders/delete.php" style="display:inline;" onsubmit="return confirm(\'Czy na pewno chcesz usunąć to zamówienie?\');">
                <input type="hidden" name="id" value="' . $row['id'] . '">
                <button type="submit">Usuń</button>
            </form>
          </td>';
    echo '</tr>';
}
echo '</table>';
?>