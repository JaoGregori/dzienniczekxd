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
include($deep.'db_connect.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dodaj ucznia</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?php echo $deep;?>style.css">
    <?php include($deep.'head.php') ?>
</head>
<body>
<div id="top">
<?php include($deep.'header1.php')?>
</div>
<div id="contener">
<div id="ContentPages">
    <br><h1>Dodaj nowego ucznia</h1>
    <div class="pageForm">
    <form method="post">
        <div class="formTable">
        <table>
        <tr><td>Imię: </td><td><input class="box" type="text" name="imie" required></td></tr>
        <tr><td>Nazwisko: </td><td><input class="box" type="text" name="nazwisko" required></td></tr>
        <tr><td>Klasa: </td><td><input class="boxNum" type="number" name="klasa" required></td></tr>
        <tr><td>Data urodzin: </td><td><input class="box" type="date" name="data_urodzin" required></td></tr>
        <tr><td>Miejscowosc: </td><td><input class="box" type="text" name="miejscowosc" required></td></tr>
        <tr><td>ulica: </td><td><input class="box" type="text" name="ulica" required></td></tr>
        <tr><td>Telefon: </td><td><input class="box" type="text" name="telef" required></td></tr>
        <tr><td>Mail: </td><td><input class="box" type="text" name="mail" required></td></tr>
        </table>
        <br>
        <center><input class="przyc1" type="submit" value="Dodaj"></center>
</div>
    </form>
    </div>
    <br>
    <a href="<?php echo $deep;?>uczniowie/uczniowie.php"><button class="przyc1">Powrót do listy uczniów</button></a>
    <?php

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
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
        header("Location: ".$deep."uczniowie/uczniowie.php");
    } else {
        echo "Błąd: " . $conn->error;
    }
}
?>
</div>
</div>
</body>
</html>

<?php
$conn->close();
?>