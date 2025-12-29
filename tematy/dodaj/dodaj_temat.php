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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $przedmiot = $_POST['przedmiot'];
    $temat = $_POST['temat'];
    $data = $_POST['data'];

    $sql = "INSERT INTO tematy_lekcji (przedmiot, temat, data) VALUES ('$przedmiot', '$temat', '$data')";
    if ($conn->query($sql) === TRUE) {
        header('Location: '.$deep.'tematy/tematy.php');
    } else {
        echo "Błąd: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="<?php echo $deep;?>style.css">
    <title>Dodaj temat</title>
    <?php include($deep.'head.php') ?>
</head>
<body>
<?php include($deep.'header1.php')?>
<div id="content">
<br><h1>Dodaj nowy temat lekcji</h1>
    <form method="POST">
        <table>
        <tr><td>Przedmiot:</td>
        <td>
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
        </td></tr>
        
        <tr><td>Temat:</td>
        <td><input class="pole" type="textarea" name="temat" required></td></tr>

        <tr><td>Data:</td>
        <td><input type="date" name="data" required></td></tr>
        </table>
        <input class="przyc1" type="submit" value="Dodaj temat">
    </form>
</div>
</body>
</html>