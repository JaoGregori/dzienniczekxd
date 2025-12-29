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
    <title>Edytuj nauczyciela</title>
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
    <h1>Edytuj nauczyciela</h1>
    <?php
    // Połączenie z bazą danych
    include($deep.'db_connect.php');

    // Pobieranie danych ucznia
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM nauczyciele WHERE id='$id'";
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
        <td><input class="box" type="text" name="przedmiot" value="<?= $row['przedmiot']; ?>" required></td></tr>
        </table><br>
        <center><input type="submit" class="przyc1" value="Zapisz zmiany"></center>
        </div>
    </form>
    </div>
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
            header("Location: ".$deep."nauczyciele/nauczyciele.php");
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