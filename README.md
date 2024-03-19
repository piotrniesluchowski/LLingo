Skrypt login.php
Opis:
Skrypt login.php obsługuje proces logowania użytkownika.

Parametry:
loginUsername: Nazwa użytkownika przekazana z formularza logowania.
loginPassword: Hasło użytkownika przekazane z formularza logowania.
Funkcje:
Połączenie z bazą danych: Nawiązuje połączenie z bazą danych MySQL.
Wyszukanie użytkownika: Przeszukuje bazę danych w poszukiwaniu użytkownika o podanej nazwie.
Sprawdzenie hasła: Porównuje hasło przesłane przez formularz z zahaszowanym hasłem w bazie danych.
Pomyślne logowanie: Jeśli hasło jest poprawne, zapisuje ID użytkownika do sesji i przekierowuje użytkownika do dashboardu.
Błędy logowania: Informuje użytkownika o błędach logowania, takich jak nieprawidłowa nazwa użytkownika lub hasło.
Skrypt register.php
Opis:
Skrypt register.php obsługuje proces rejestracji nowego użytkownika.

Parametry:
registerUsername: Nazwa użytkownika przekazana z formularza rejestracji.
registerEmail: Adres e-mail użytkownika przekazany z formularza rejestracji.
registerPassword: Hasło użytkownika przekazane z formularza rejestracji.
Funkcje:
Połączenie z bazą danych: Nawiązuje połączenie z bazą danych MySQL.
Dodanie nowego użytkownika: Wstawia dane nowego użytkownika do tabeli Users w bazie danych.
Komunikaty zwrotne: Informuje użytkownika o pomyślnym zarejestrowaniu lub błędach podczas procesu rejestracji.
Skrypt delete_deck.php
Opis:
Skrypt delete_deck.php obsługuje proces usuwania decka przez użytkownika.

Parametry:
deck_id: ID decka do usunięcia.
Funkcje:
Połączenie z bazą danych: Nawiązuje połączenie z bazą danych MySQL.
Sprawdzenie właściciela: Sprawdza, czy użytkownik jest właścicielem decka.
Usuwanie decka: Usuwa deck z bazy danych, jeśli użytkownik jest jego właścicielem.
Komunikaty zwrotne: Informuje użytkownika o wyniku operacji usuwania decka.
Skrypt skip_card.php
Opis:
Skrypt skip_card.php obsługuje pominięcie obecnej fiszki w quizie.

Funkcje:
Pominięcie fiszki: Przenosi pierwszą fiszkę na koniec listy, umożliwiając użytkownikowi powtórzenie jej później.
Przekierowanie: Przekierowuje użytkownika z powrotem do strony quizu.
Skrypt retry_quiz.php
Opis:
Skrypt retry_quiz.php obsługuje ponowne rozpoczęcie quizu po zakończeniu.

Funkcje:
Przeniesienie fiszek: Przenosi pierwszą fiszkę na koniec listy, umożliwiając użytkownikowi ponowne przetestowanie jej.
Przekierowanie: Przekierowuje użytkownika z powrotem do strony quizu.
Skrypt create_deck.php
Opis:
Skrypt create_deck.php obsługuje proces tworzenia nowego decka przez użytkownika.

Parametry:
newDeckName: Nazwa nowego decka przekazana z formularza.
Funkcje:
Połączenie z bazą danych: Nawiązuje połączenie z bazą danych MySQL.
Dodanie nowego decka: Wstawia nowy deck do bazy danych dla zalogowanego użytkownika.
Komunikaty zwrotne: Informuje użytkownika o wyniku operacji tworzenia nowego decka.
Skrypt delete_card.php
Opis:
Skrypt delete_card.php obsługuje proces usuwania fiszki z decka przez użytkownika.

Parametry:
card_id: ID fiszki do usunięcia.
Funkcje:
Połączenie z bazą danych: Nawiązuje połączenie z bazą danych MySQL.
Sprawdzenie właściciela: Sprawdza, czy użytkownik jest właścicielem decka zawierającego fiszkę.
Usuwanie fiszki: Usuwa fiszkę z bazy danych, jeśli użytkownik jest jej właścicielem.
Komunikaty zwrotne: Informuje użytkownika o wyniku operacji usuwania fiszki.
Ta dokumentacja zawiera opisy i funkcje każdego z głównych skryptów PHP w dostarczonym kodzie.
