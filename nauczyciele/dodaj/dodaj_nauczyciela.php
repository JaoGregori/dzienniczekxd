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
<?php
include($deep.'db_connect.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $przedmiot = $_POST['przedmiot'];

    $sql = "INSERT INTO nauczyciele (imie, nazwisko, przedmiot) VALUES ('$imie', '$nazwisko', '$przedmiot')";
    if($conn->query($sql)){
        header("Location: ".$deep."nauczyciele/nauczyciele.php");
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
    <link rel="stylesheet" href="<?php echo $deep;?>style.css">
    <?php include($deep.'head.php') ?>
</head>

<body>
<div id="top">
<?php include($deep.'header1.php')?>
</div>
<div id="contener">
<div id="ContentPages">
    <h1>Dodaj nowego nauczyciela</h1>
    <div class="pageForm">
    <form method="post">
    
        <table>
        <tr><td>Imię:</td><td><input class="box" type="text" name="imie" required></td></tr>
        <tr><td>Nazwisko:</td><td><input class="box" type="text" name="nazwisko" required></td></tr>
        <tr><td>Przedmiot:</td><td><input class="box" type="text" name="przedmiot" required></td></tr>
        </table>
        <button class="przyc1" type="submit" value="Dodaj">Dodaj</button><br><br>
        
    </form>
    </div>
    <a href="nauczyciele.php"><button class="przyc1" >Powrót do listy nauczycieli</button></a>
</div>   
</div>
</body>
</html>

<?php
$conn->close();
?>