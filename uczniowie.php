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
    <title>Uczniowie</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <?php include('head.php') ?>
</head>
<body>
    <?php include('header1.php')?>
    <div id="content">
    <br><h1>Lista uczniów</h1>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>Klasa</th>
            <th>Data urodzin</th>
            <th>Miejscowosc</th>
            <th>Ulica</th>
            <th>Telefon</th>
            <th>Mail</th>
            <th>Akcje</th>
        </tr>
        <?php
// Połączenie z bazą danych
include('db_connect.php');

// Pobieranie listy uczniów
$sql = "SELECT * FROM uczniowie";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){ ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['imie']; ?></td>
            <td><?= $row['nazwisko']; ?></td>
            <td><?= $row['klasa']; ?></td>
            <td><?= $row['data_urodzin']; ?></td>
            <td><?= $row['miejscowosc']; ?></td>
            <td><?= $row['ulica']; ?></td>
            <td><?= $row['telef']; ?></td>
            <td><?= $row['mail']; ?></td>
            <td>
                <a href="edytuj_ucznia.php?id=<?= $row['id']; ?>">Edytuj</a> |
                <a href="usun_ucznia.php?id=<?= $row['id']; ?>">Usuń</a>
            </td>
        </tr>
        <?php } ?>
    </table>
    <a href="dodaj_ucznia.php"><button class="przyc1">Dodaj nowego ucznia</button></a>
</div>
</body>
</html>

<?php
// $conn->close();
?>