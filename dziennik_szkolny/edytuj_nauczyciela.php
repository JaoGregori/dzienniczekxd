
<?php
session_start();

if (!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}
include('sprupr.php');

?>
<!DOCTYPE html>
<html>
<head>
    <title>Edytuj nauczyciela</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <?php include('head.php') ?>
</head>
<body>
<?php include('header1.php')?>
<br><h1>Edytuj nauczyciela</h1>
    <?php
    // Połączenie z bazą danych
    include('db_connect.php');

    // Pobieranie danych ucznia
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM nauczyciele WHERE id='$id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
    }
    ?>

    <form action="edytuj_nauczyciela.php" method="POST">
        <input type="hidden" name="id" value="<?= $row['id']; ?>">
        <label>Imię:</label>
        <input type="text" name="imie" value="<?= $row['imie']; ?>" required><br>
        <label>Nazwisko:</label>
        <input type="text" name="nazwisko" value="<?= $row['nazwisko']; ?>" required><br>
        <label>Klasa:</label>
        <input type="text" name="przedmiot" value="<?= $row['przedmiot']; ?>" required><br>
        <input type="submit" class="przyc1" value="Zapisz zmiany">
    </form>

    <?php
    // Aktualizacja danych ucznia
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $imie = $_POST['imie'];
        $nazwisko = $_POST['nazwisko'];
        $przedmiot = $_POST['przedmiot'];

        $sql = "UPDATE nauczyciele SET imie='$imie', nazwisko='$nazwisko', przedmiot='$przedmiot' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo "Dane nauczyciela zostały zaktualizowane.";
            header("Location: nauczyciele.php");
            exit();
        } else {
            echo "Błąd: " . $conn->error;
        }
    }

    $conn->close();
    ?>
</body>
</html>