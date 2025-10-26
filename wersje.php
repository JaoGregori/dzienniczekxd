<?php
session_start();

if (!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Oceny</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <?php include('head.php') ?>
</head>
<body>
<?php include('header1.php');
include('db_connect.php');?>
<div id="content">

<br>
    <h2>Wersje tegoż dziennika oraz informacje o aktualizacji</h2>
    <ul>
    <li>0.1 Utworzenie strony z podstawowymi zakładkami.</li>
    <li>0.2 Dodanie różnych rzeczy (nie wiem)</li>
    <li>0.3 Dodano Obecności</li>
    <li>0.3.1 Usprawnianie działania systemu sprawdzania obecności</li>
    <li>0.3.2 Odnowienie wyglądu witryny</li>
    <li>0.4 Rewolucja w ocenach</li>
    <li>0.5 Dodano oceny seryjne, poprawiono edytowanie i usuwanie, odnowiono sprawdzanie obecności</li>
    <li>0.5.1 Dodano kolory ocen</li>
    <li>0.6.0 Nowy interfejs dodawania obecności, ocen itp. <br>Dodano interfejs ucznia<br>System ocen i obecności ulepszony o: wyświetlanie informacji po najechaniu myszką, łatwiejsza edycja, lepszy interfejs dodawania/edytowania<br>System logowania (zabezpieczenia)<br>Poprawienie systemu dodawania i sprawdzania obecności<br>Nowa strona główna</li>
    <li>0.6.1 Wyświetlanie obecności jest teraz dokładniejsze.</li>
    <li>0.6.2 Poprawka kodu oraz poprawa interfejsu</li> 
    </ol>
</div>
</body>
</html>