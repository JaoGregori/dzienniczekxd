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
    $przedmiot = $_POST['przedmiot'];

    $sql = "INSERT INTO nauczyciele (imie, nazwisko, przedmiot) VALUES ('$imie', '$nazwisko', '$przedmiot')";
    if($conn->query($sql)){
        header("Location: nauczyciele.php");
    } else {
        echo "Błąd: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<br><title>Dodaj nauczyciela</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <?php include('head.php') ?>
</head>

<body>
<?php include('header1.php')?>
<div id="content">
    <h1>Dodaj nowego nauczyciela</h1>
    <form method="post">
        <table>
        <tr><td>Imię:</td><td><input type="text" name="imie" required></td></tr>
        <tr><td>Nazwisko:</td><td><input type="text" name="nazwisko" required></td></tr>
        <tr><td>Przedmiot:</td><td><input type="text" name="przedmiot" required></td></tr>
        </table>
        <br>
        <button class="przyc1" type="submit" value="Dodaj">Dodaj</button><br><br>
    </form>
    <a href="nauczyciele.php"><button class="przyc1" >Powrót do listy nauczycieli</button></a>
    
</div>
</body>
</html>

<?php
$conn->close();
?>