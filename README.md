## Instalacja
1. Sklonuj repozytorium:
```bash
git clone git@github.com:olafbado/sea_logistics.git
cd sea_logistics
```

2. Uruchom skrypt setup.php, aby utworzyć tabele i wstawić przykładowe dane:
```bash
php setup.php
```

3. Uruchom serwer:
```bash
php -S localhost:8000
```

4. Otwórz przeglądarkę i wpisz w pasek adresu:
```bash
http://localhost:8000
```

## Opis Modułów i funkcjonalności

### index.php
Strona główna aplikacji.

### login.php
Strona logowania.

### logout.php
Wylogowanie użytkownika.

### register.php
Strona rejestracji.

### setup.php
Skrypt do tworzenia tabel w bazie danych i wstawiania przykładowych danych.

### includes/
Moduł `includes` zawiera pliki z funkcjami pomocniczymi:
- `db.php` - połączenie z bazą danych.
- `footer.php` - stopka strony.
- `header.php` - nagłówek strony.
- `search.php` - formularz do wyszukiwania zleceń.

### orders/
Moduł `orders` zawiera pliki do zarządzania zleceniami:
- `add.php` - formularz do dodawania nowego zlecenia.
- `edit.php` - formularz do edytowania istniejącego zlecenia.
- `delete.php` - skrypt do usuwania zlecenia.
- `details.php` - wyświetlanie szczegółów zlecenia.
- `list.php` - wyświetlanie listy zleceń.

### ships/
Moduł `ships` zawiera pliki do zarządzania statkami:
- `add.php` - formularz do dodawania nowego statku.
- `edit.php` - formularz do edytowania istniejącego statku.
- `delete.php` - skrypt do usuwania statku.
- `details.php` - wyświetlanie szczegółów statku.
- `list.php` - wyświetlanie listy statków.

## Użytkowanie
1. Zaloguj się na instniejące konto np. login: `test`, hasło: `test` lub zarejestruj nowe konto. Zostaniesz przeniesiony na stronę główną gdzie znajdziesz listę zleceń.
2. Przejdź do zakładki `Dodaj Zlecenie`
3. Wypełnij formularz, wprowadź zawartość pliku lub dodaj plik i zatwierdź.
4. W pasku wyszukiwania wpisz `tytuł` zlecenia które dodałeś, aby je znaleźć.
5. Kliknij `Edytuj` obok dodanego zlecenia, aby przejść do formularza edycji.
6. Edytuj dane i zatwierdź.
7. Kliknij `Szczegóły` obok dodanego zlecenia, aby zobaczyć szczegółowe informacje.
8. Kliknij `Powrót` aby wrócić do listy zleceń.
9. Kliknij `Usuń` obok dodanego zlecenia, aby je usunąć.
10. Przejdź do zakładki `Lista Statków` aby zobaczyć listę statków.
11. Powtórz poprzednie kroki aby dodać, edytować, wyświetlić i usunąć statki.
12. Kliknij `Wyloguj` aby się wylogować.