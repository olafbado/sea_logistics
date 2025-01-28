<form class="search-bar" method="GET" action="<?= htmlspecialchars($action) ?>">
    <input type="hidden" name="page" value="<?= htmlspecialchars($_GET['page'] ?? '') ?>">
    <input type="text" name="search" placeholder="Szukaj" value="<?= htmlspecialchars($search ?? '') ?>">
    <button type="submit">Szukaj</button>
</form>