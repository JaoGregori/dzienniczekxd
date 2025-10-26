<?php
session_start();

if (!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}


?><!DOCTYPE html>
<html>
<head>
    <title>Nauczyciele</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <?php include('head.php') ?>
</head>
<body>
<?php include('header1.php')?>
<br><h1>Lista nauczycieli</h1>
    <a href="dodaj_nauczyciela.php">Dodaj nowego nauczyciela</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>przedmiot</th>
        
        </tr>
        <?php
// Połączenie z bazą danych
include('db_connect.php');

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
                <a href="edytuj_nauczyciela.php?id=<?= $row['id']; ?>">Edytuj</a> |
                <a href="usun_nauczyciela.php?id=<?= $row['id']; ?>">Usuń</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php
// $conn->close();
?>