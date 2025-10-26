<?php
session_start();

if (!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}
include('sprupr.php');

?>
<?php
include('db_connect.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $klasa = $_POST['klasa'];
    $data_urodzin = $_POST['data_urodzin'];
    $miejscowosc = $_POST['miejscowosc'];
    $ulica = $_POST['ulica'];
    $telef = $_POST['telef'];
    $mail = $_POST['mail'];

    $sql = "INSERT INTO uczniowie (imie, nazwisko, klasa, data_urodzin, miejscowosc, ulica, telef, mail) 
    VALUES ('$imie', '$nazwisko', '$klasa', '$data_urodzin', '$miejscowosc', '$ulica', '$telef', '$mail')";
    if($conn->query($sql)){
        header("Location: uczniowie.php");
    } else {
        echo "Błąd: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dodaj ucznia</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <?php include('head.php') ?>
</head>
<body>
<?php include('header1.php')?>
<div id="content">
    <br><h1>Dodaj nowego ucznia</h1>
    <form method="post">
        <table>
        <tr><td>Imię: </td><td><input type="text" name="imie" required></td></tr>
        <tr><td>Nazwisko: </td><td><input type="text" name="nazwisko" required></td></tr>
        <tr><td>Klasa: </td><td><input type="text" name="klasa" required></td></tr>
        <tr><td>Data urodzin: </td><td><input type="date" name="data_urodzin" required></td></tr>
        <tr><td>Miejscowosc: </td><td><input type="text" name="miejscowosc" required></td></tr>
        <tr><td>ulica: </td><td><input type="text" name="ulica" required></td></tr>
        <tr><td>Telefon: </td><td><input type="text" name="telef" required></td></tr>
        <tr><td>Mail: </td><td><input type="text" name="mail" required></td></tr>
        </table>
        <input class="przyc1" type="submit" value="Dodaj">
    </form><br>
    <a href="uczniowie.php"><button class="przyc1">Powrót do listy uczniów</button></a>
</div>
</body>
</html>

<?php
$conn->close();
?>