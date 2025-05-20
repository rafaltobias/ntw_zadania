# System Testowania Wiedzy

System webowy do tworzenia i przeprowadzania testów jednokrotnego wyboru, zrealizowany w architekturze MVC dla PHP.

## Funkcjonalności

### Dla nauczycieli:
- Zarządzanie kontem
- Zarządzanie uczniami (dodawanie, usuwanie, edycja)
- Grupowanie uczniów w klasy
- Tworzenie i zarządzanie bankiem pytań
- Tworzenie testów z pytań w banku
- Przypisywanie testów do uczniów lub całych klas
- Przeglądanie wyników osiągniętych przez uczniów

### Dla uczniów:
- Logowanie do aplikacji
- Przeglądanie dostępnych testów
- Rozwiązywanie przydzielonych testów
- Przeglądanie wyników i poprawnych odpowiedzi

## Wymagania systemowe

- PHP 7.4 lub nowszy
- MySQL 5.7 lub nowszy
- Serwer WWW (np. Apache, Nginx)
- XAMPP (lub inny pakiet zawierający PHP i MySQL)

## Instalacja

1. Sklonuj lub pobierz repozytorium do katalogu `htdocs` w Twojej instalacji XAMPP.
2. Utwórz bazę danych MySQL o nazwie `quiz_system`.
3. Zaimportuj plik `database/setup.sql` do utworzonej bazy danych.
4. Otwórz plik `app/config/database.php` i skonfiguruj połączenie z bazą danych.
5. Otwórz plik `app/config/config.php` i dostosuj ścieżkę URL_ROOT do Twojego środowiska.

## Uruchomienie

1. Uruchom XAMPP i upewnij się, że serwer Apache oraz MySQL są aktywne.
2. Otwórz przeglądarkę i przejdź do adresu `http://localhost/quiz_system/`.
3. Zaloguj się na domyślne konto nauczyciela:
   - Login: `teacher`
   - Hasło: `password`

## Struktura aplikacji

Aplikacja została zbudowana w architekturze MVC (Model-View-Controller):

- `/app` - główny katalog aplikacji
  - `/config` - pliki konfiguracyjne
  - `/controllers` - kontrolery obsługujące logikę aplikacji
  - `/core` - podstawowe klasy frameworka
  - `/models` - modele danych
  - `/views` - pliki widoków
- `/public` - zasoby publiczne (CSS, JS, obrazy)
- `/database` - pliki bazy danych

## Konta użytkowników

Domyślnie w systemie istnieje jedno konto nauczyciela:
- Login: `teacher`
- Hasło: `password`

Konta uczniów można tworzyć zalogowanym na konto nauczyciela.

## Jak korzystać z systemu

### Jako nauczyciel:

1. Zaloguj się na konto nauczyciela
2. Dodaj uczniów w sekcji "Uczniowie"
3. Utwórz klasy i przypisz do nich uczniów
4. Dodaj pytania do banku pytań
5. Utwórz test, wybierając pytania z banku
6. Przypisz test do uczniów lub całych klas
7. Przeglądaj wyniki w sekcji "Wyniki"

### Jako uczeń:

1. Zaloguj się na swoje konto (utworzone przez nauczyciela)
2. Przejdź do sekcji "Dostępne testy"
3. Wybierz test i rozwiąż go
4. Po zakończeniu testu, przejrzyj swoje wyniki i poprawne odpowiedzi
