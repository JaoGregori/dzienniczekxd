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
    <title>Tematy lekcji</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <?php include('head.php') ?>
</head>

<body>
<?php include('header1.php')?>
<br><h1>Lista tematów lekcji</h1>
    <a href="dodaj_temat.php">Dodaj nowy temat</a>

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
        include('db_connect.php');

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
                <a href="edytuj_temat.php?id=<?= $row['id']; ?>">Edytuj</a> |
                <a href="usun_temat.php?id=<?= $row['id']; ?>">Usuń</a>
            </td>
        </tr>
        <?php } ?>

    </table>
</body>

</html>

<?php
// Zamknięcie połączenia
$conn->close();
?>