<?php
$korzen = __DIR__."/";
include('deep.php');
include($deep.'session.php');

if (!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Wersje dziennika</title>
    <link rel="icon" type="image/x-icon" href="icon.png">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <?php include('head.php') ?>
</head>
<body>
<div id="top">
<?php include('header1.php');
include('db_connect.php');?>
</div>
<div id="contener">
<div id="ContentPages">
    <h2>Wersje tegoż dziennika oraz informacje o aktualizacji</h2>
    <ul>
    <li><b>0.1</b><br>- Utworzenie strony z podstawowymi zakładkami.</li>
    <li><b>0.2</b><br>- Dodanie różnych rzeczy (nie wiem)</li>
    <li><b>0.3</b><br>- Dodano Obecności</li>
    <li><b>0.3.1</b><br>- Usprawnianie działania systemu sprawdzania obecności</li>
    <li><b>0.3.2</b><br>- Odnowienie wyglądu witryny</li>
    <li><b>0.4</b><br>- Rewolucja w ocenach</li>
    <li><b>0.5</b><br>- Dodano oceny seryjne, poprawiono edytowanie i usuwanie, odnowiono sprawdzanie obecności</li>
    <li><b>0.5.1</b><br>- Dodano kolory ocen</li>
    <li><b>0.6.0</b><br>- Nowy interfejs dodawania obecności, ocen itp. <br>- Dodano interfejs ucznia<br>- System ocen i obecności ulepszony o: wyświetlanie informacji po najechaniu myszką, łatwiejsza edycja, lepszy interfejs dodawania/edytowania<br>- System logowania (zabezpieczenia)<br>- Poprawienie systemu dodawania i sprawdzania obecności<br>- Nowa strona główna</li>
    <li><b>0.6.1</b><br>- Wyświetlanie obecności jest teraz dokładniejsze.</li>
    <li><b>0.6.2</b><br>- Poprawka kodu oraz poprawa interfejsu</li>
    <li><b>0.6.3</b><br>- Poprawka uprawnień</li>
    <li><b>0.6.4</b><br>- Uporządkowanie ścieżek stron<br>- Poprawki błędów i interfejsu</li>
    <li><b>1.0 REWOLUCJA</b><br>- Nowy wygląd interfejsu. Poprawiony CSS<br>- Duże poprawki działania strony<ul><li>Naprawa uprawnień użytkowników</li><li>Naprawa systemu wylogowywania</li><li>Przedłużony czas logowania</li><li>Favicon naprawiony</li></ul>- Przygotowanie strony do dodania nowych funkcji w kolejnych wersjach.</li>
    </ul>
</div>
</div>
</body>
</html>