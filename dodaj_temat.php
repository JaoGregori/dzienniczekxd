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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $przedmiot = $_POST['przedmiot'];
    $temat = $_POST['temat'];
    $data = $_POST['data'];

    $sql = "INSERT INTO tematy_lekcji (przedmiot, temat, data) VALUES ('$przedmiot', '$temat', '$data')";
    if ($conn->query($sql) === TRUE) {
        echo "Nowy temat został dodany!";
    } else {
        echo "Błąd: " . $sql . "<br>" . $conn->error;
    }
}


?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
    <title>Dodaj temat</title>
    <?php include('head.php') ?>
</head>
<body>
<?php include('header1.php')?>
<br><h1>Dodaj nowy temat lekcji</h1>
    <form method="POST">
        <label>Przedmiot:</label>
        <?php
        echo '<select name="przedmiot" id="przedmiot" required>';
    
        $sql = "SELECT przedmiot FROM przedmioty    ;";
        $result = $conn->query($sql);
        
        while ($row = $result->fetch_assoc())
        {
            echo '<option value="'.$row["przedmiot"].'">'.$row["przedmiot"].'</option>';
        }
        echo '</select>';
        $conn->close();
        ?>
        <br>

        <label>Temat:</label>
        <input class="pole" type="textarea" name="temat" required><br>

        <label>Data:</label>
        <input type="date" name="data" required><br>

        <input type="submit" value="Dodaj temat">
    </form>
</body>
</html>