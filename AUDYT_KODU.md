# Audyt kodu (ocena krytyczna)

## Ocena ogólna
**3/10** – aplikacja działa i ma spójny układ modułów CRUD, ale obecna implementacja zawiera krytyczne ryzyka bezpieczeństwa (SQL Injection, brak haszowania haseł, dane dostępowe do DB w repo, słaba sesja), które realnie narażają dane uczniów i nauczycieli.

## Najważniejsze problemy (priorytet P0/P1)

### P0 – Dane dostępowe do bazy zapisane na sztywno
W `db_connect.php` host, login, hasło, nazwa bazy i port są wpisane bezpośrednio w kodzie.

**Ryzyko:** wyciek repo = pełny dostęp do bazy.

**Rekomendacja:** przenieść dane do zmiennych środowiskowych (`$_ENV`) i dodać `.env.example` bez sekretów.

---

### P0 – Logowanie na hasłach w plaintext
W `zaloguj.php` logowanie porównuje wartości `login` i `haslo` bez `password_hash()` / `password_verify()`.

**Ryzyko:** przejęcie haseł po wycieku DB; brak zgodności z podstawowymi praktykami bezpieczeństwa.

**Rekomendacja:** migracja kolumny hasła do hashy bcrypt/argon2 i użycie `password_verify()`.

---

### P0 – SQL Injection w wielu miejscach
W kodzie występują zapytania budowane przez interpolację `$_GET` / `$_POST`, np.:
- `uczniowie/usun/usun_ucznia.php` (`DELETE ... WHERE id='$id'`),
- `oceny/dodaj/dodaj_ocene.php` (zapytania z `$_GET` i `INSERT` z wielu pól formularza),
- `uczniowie/uczniowie.php` (`WHERE klasa='$classa'`),
- `header1.php` (`WHERE id='$idu'`).

**Ryzyko:** odczyt/modyfikacja/usuwanie danych przez atakującego.

**Rekomendacja:** wszędzie przejść na prepared statements (`$conn->prepare`, `bind_param`).

---

### P0 – Operacje usuwania przez GET + brak ochrony CSRF
Usuwanie rekordów odbywa się przez linki GET (np. `.../usun_ucznia.php?id=...`) i brak tokenów CSRF.

**Ryzyko:** przypadkowe/ukryte usuwanie rekordów po wejściu w spreparowany link.

**Rekomendacja:** tylko POST/DELETE + token CSRF + potwierdzenie operacji.

---

### P1 – Potencjalne XSS (brak escapowania danych przy renderze)
W widokach dane z DB są wypisywane bez `htmlspecialchars`, np. w `uczniowie/uczniowie.php` przez `<?= $row['...']; ?>`.

**Ryzyko:** osadzenie złośliwego JS w danych i wykonanie w przeglądarce użytkownika.

**Rekomendacja:** escapowanie każdego pola przy renderowaniu HTML.

---

### P1 – Słabe zarządzanie sesją
W `session.php` jest tylko `session_set_cookie_params(1800); session_start();` – brak flag `httponly`, `secure`, `samesite`, brak `session_regenerate_id()` po logowaniu.

**Ryzyko:** zwiększone ryzyko session hijacking/fixation.

**Rekomendacja:** wymusić bezpieczne cookie i regenerować ID sesji po poprawnym logowaniu.

---

### P1 – Uprawnienia oparte o „magiczną” wartość ID
W `header1.php` dostęp do sekcji administracyjnych zależy od warunku `$_SESSION['uzytkownik'] < 13`.

**Ryzyko:** podatny model autoryzacji, trudny w utrzymaniu i audycie.

**Rekomendacja:** role/permisje w DB (`role = admin/nauczyciel/uczen`) i centralny middleware autoryzacji.

## Co jest na plus
- Projekt ma prostą, czytelną strukturę katalogów wg modułów (uczniowie/oceny/obecnosci/tematy/loginy).
- Sprawdzenia sesji są obecne na wielu stronach.
- Kod przechodzi `php -l` (brak błędów składni).

## Plan naprawczy (kolejność)
1. **Natychmiast:** rotacja sekretów DB i usunięcie ich z repo.
2. **Tydzień 1:** prepared statements i ochrona CSRF dla operacji modyfikujących.
3. **Tydzień 1:** migracja haseł na `password_hash`/`password_verify`.
4. **Tydzień 2:** pełne escapowanie outputu HTML (`htmlspecialchars`).
5. **Tydzień 2:** refaktor autoryzacji do ról i centralnych guardów.
6. **Tydzień 3:** testy bezpieczeństwa (przynajmniej smoke testy SQLi/XSS/CSRF).

## Podsumowanie
Jeśli to ma działać produkcyjnie, obecny stan **wymaga pilnych poprawek bezpieczeństwa przed dalszym rozwojem funkcjonalnym**.
