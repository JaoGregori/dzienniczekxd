<?php
include($deep.'session.php');
include('deep.php');

if (!isset($_SESSION['zalogowany']))
{
    header('Location: ../index.php');
    exit();
}
$korzen = __DIR__."/";
?><!DOCTYPE html>
<html>
<head>
    <title>Nauczyciele</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" type="image/x-icon" href="../icon.png">
    <?php include('../head.php') ?>
</head>
<body>
<div id="top">
<?php include('../header1.php')?>
</div>
<div id="contener">
<div id="ContentPages">
    <h1>Lista nauczycieli</h1>
    <div id="tabOS">
    <table>
        <tr>
            <th>ID</th>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>przedmiot</th>
            <th>Akcja</th>
        </tr>
        <?php
// Połączenie z bazą danych
include('../db_connect.php');

// Pobieranie listy uczniów
$sql = "SELECT * FROM nauczyciele";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){ ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['imie']; ?></td>
            <td><?= $row['nazwisko']; ?></td>
            <td><?= $row['przedmiot']; ?></td>
            <td>
                <a href="edytuj/edytuj_nauczyciela.php?id=<?= $row['id']; ?>"><button class="minwyb">Edytuj</button></a> 
                <a href="usun/usun_nauczyciela.php?id=<?= $row['id']; ?>"><button class="minwyb">Usuń</button></a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
    <br>
    <a href="dodaj/dodaj_nauczyciela.php"><button class="przyc1">Dodaj nowego nauczyciela</button></a>
</div>
</div>
</body>
</html>

<?php
// $conn->close();
?>