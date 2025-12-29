<?php
$korzen = __DIR__."/";
include('deep.php');
include($deep.'session.php');

if (!isset($_SESSION['zalogowany']))
{
    header('Location: '.$deep.'index.php');
    exit();
}
include($deep.'sprupr.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edytuj Ucznia</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?php echo $deep;?>style.css">
    <?php include($deep.'head.php') ?>
</head>
<body>
<div id="top">
<?php include($deep.'header1.php')?>
</div>
<div id="contener">
<br><h1>Edytuj Ucznia</h1>
    <div id="ContentPage">
    <?php
    // Połączenie z bazą danych
    include($deep.'db_connect.php');

    // Pobieranie danych ucznia
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM uczniowie WHERE id='$id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
    }
    ?>
    <div class="pageForm">
    <form method="POST">

        <input type="hidden" name="id" value="<?= $row['id']; ?>">
        <div class="formTable">
        <table>
        <tr><td>Imię:</td>
        <td><input class="box" type="text" name="imie" value="<?= $row['imie']; ?>" required></td></tr>
        <tr><td>Nazwisko:</td>
        <td><input class="box" type="text" name="nazwisko" value="<?= $row['nazwisko']; ?>" required></td></tr>
        <tr><td>Klasa:</td>
        <td><input class="boxNum" type="number" name="klasa" value="<?= $row['klasa']; ?>" required></td></tr>
        <tr><td>Data urodzin:</td>
        <td><input class="box" type="date" name="data_urodzin" value="<?= $row['data_urodzin']; ?>" required></td></tr>
        <tr><td>Miejscowosc:</td>
        <td><input class="box" type="text" name="miejscowosc" value="<?= $row['miejscowosc']; ?>" required></td></tr>
        <tr><td>Ulica:</td>
        <td><input class="box" type="text" name="ulica" value="<?= $row['ulica']; ?>" required></td></tr>
        <tr><td>Telefon:</td>
        <td><input class="box" type="text" name="telef" value="<?= $row['telef']; ?>" required></td></tr>
        <tr><td>Mail:</td>
        <td><input class="box" type="text" name="mail" value="<?= $row['mail']; ?>" required></td></tr>
        </table><br>
        <center><input class="przyc1" type="submit" value="Zapisz zmiany"></center>
</div>
    </form>
</div>
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
            header("Location: ".$deep."uczniowie/uczniowie.php");
            exit();
        } else {
            echo "Błąd: " . $conn->error;
        }
    }

    $conn->close();
    ?>
</div>
</div>
</body>
</html>