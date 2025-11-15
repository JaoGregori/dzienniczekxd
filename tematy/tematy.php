<?php
$korzen = __DIR__."/";
session_start();

if (!isset($_SESSION['zalogowany']))
{
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Tematy lekcji</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" type="image/x-icon" href="../icon.png">
    <?php include('../head.php') ?>
</head>

<body>
<?php include('../header1.php')?>
<div id="content">
<br><h1>Lista tematów lekcji</h1>
    

    <table>
        <tr>
            <th>ID</th>
            <th>Przedmiot</th>
            <th>Temat</th>
            <th>Data</th>
            <th>Akcje</th>
        </tr>

        <?php
        // Połączenie z bazą danych
        include('../db_connect.php');

        // Pobieranie listy tematów lekcji
        $sql = "SELECT * FROM tematy_lekcji";
        $result = $conn->query($sql);

        // Wyświetlanie każdego wiersza z tabeli "tematy"
        while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['przedmiot']; ?></td>
            <td><?= $row['temat']; ?></td>
            <td><?= $row['data']; ?></td>
            <td>
                <a href="edytuj/edytuj_temat.php?id=<?= $row['id']; ?>">Edytuj</a> |
                <a href="usun/usun_temat.php?id=<?= $row['id']; ?>">Usuń</a>
            </td>
        </tr>
        <?php } ?>

    </table>
    <a href="dodaj/dodaj_temat.php"><button class="przyc1">Dodaj nowy temat</button></a>
</div>
</body>

</html>

<?php
// Zamknięcie połączenia
$conn->close();
?>