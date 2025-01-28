<?php
require 'includes/db.php';

$search = $_GET['search'] ?? '';

// Pobieranie danych z bazy z uwzględnieniem wyszukiwania
$stmt = $db->prepare("SELECT * FROM ships WHERE name LIKE ?");
$stmt->execute(['%' . $search . '%']);

echo '<h2>Lista Statków</h2>';
$action = 'index.php?page=ships';
include 'includes/search.php';
echo '<table border="1">';
echo '<tr><th>Nazwa</th><th>Akcje</th></tr>';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td>' . $row['name'] . '</td>';
    echo '<td>
            <a href="ships/details.php?id=' . $row['id'] . '">Szczegóły</a>
            <a href="ships/edit.php?id=' . $row['id'] . '">Edytuj</a>
            <form method="post" action="ships/delete.php" style="display:inline;" onsubmit="return confirm(\'Czy na pewno chcesz usunąć ten statek?\');">
                <input type="hidden" name="id" value="' . $row['id'] . '">
                <button type="submit">Usuń</button>
            </form>
          </td>';
    echo '</tr>';
}
echo '</table>';
?>