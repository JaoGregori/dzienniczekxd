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
    <title>Edytuj Ucznia</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <?php include('head.php') ?>
</head>
<body>
<?php include('header1.php')?>
<br><h1>Edytuj Ucznia</h1>
    <?php
    // Połączenie z bazą danych
    include('db_connect.php');

    // Pobieranie danych ucznia
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM uczniowie WHERE id='$id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
    }
    ?>

    <form action="edytuj_ucznia.php" method="POST">
        <input type="hidden" name="id" value="<?= $row['id']; ?>">
        <label>Imię:</label>
        <input type="text" name="imie" value="<?= $row['imie']; ?>" required><br>
        <label>Nazwisko:</label>
        <input type="text" name="nazwisko" value="<?= $row['nazwisko']; ?>" required><br>
        <label>Klasa:</label>
        <input type="text" name="klasa" value="<?= $row['klasa']; ?>" required><br>
        <label>Data urodzin:</label>
        <input type="date" name="data_urodzin" value="<?= $row['data_urodzin']; ?>" required><br>
        <label>Miejscowosc:</label>
        <input type="text" name="miejscowosc" value="<?= $row['miejscowosc']; ?>" required><br>
        <label>Ulica:</label>
        <input type="text" name="ulica" value="<?= $row['ulica']; ?>" required><br>
        <label>Telefon:</label>
        <input type="telef" name="telef" value="<?= $row['telef']; ?>" required><br>
        <label>Mail:</label>
        <input type="text" name="mail" value="<?= $row['mail']; ?>" required><br>
        <input class="przyc1" type="submit" value="Zapisz zmiany">
    </form>

    <?php
    // Aktualizacja danych ucznia
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $imie = $_POST['imie'];
        $nazwisko = $_POST['nazwisko'];
        $klasa = $_POST['klasa'];
        $data_urodzin = $_POST['data_urodzin'];
        $miejscowosc = $_POST['miejscowosc'];
        $ulica = $_POST['ulica'];
        $telef = $_POST['telef'];
        $mail = $_POST['mail'];

        $sql = "UPDATE uczniowie SET imie='$imie', nazwisko='$nazwisko', klasa='$klasa', data_urodzin='$data_urodzin', miejscowosc='$miejscowosc', ulica='$ulica', telef='$telef', mail='$mail' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo "Dane ucznia zostały zaktualizowane.";
            header("Location: uczniowie.php");
            exit();
        } else {
            echo "Błąd: " . $conn->error;
        }
    }

    $conn->close();
    ?>
</body>
</html>