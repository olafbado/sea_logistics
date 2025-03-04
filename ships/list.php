<?php
require 'includes/functions.php';
require 'includes/db.php';

redirectIfNotLoggedIn();

$search = $_GET['search'] ?? '';

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
            <form method="get" action="ships/details.php" style="display:inline;">
                <input type="hidden" name="id" value="' . $row['id'] . '">
                <button type="submit">Szczegóły</button>
            </form>
            <form method="get" action="ships/edit.php" style="display:inline;">
                <input type="hidden" name="id" value="' . $row['id'] . '">
                <button type="submit">Edytuj</button>
            </form>
            <form method="post" action="ships/delete.php" style="display:inline;" onsubmit="return confirm(\'Czy na pewno chcesz usunąć ten statek?\');">
                <input type="hidden" name="id" value="' . $row['id'] . '">
                <button type="submit">Usuń</button>
            </form>
          </td>';
    echo '</tr>';
}
echo '</table>';
?>