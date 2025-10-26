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

$id = $_GET['id'];
$sql = "SELECT * FROM tematy_lekcji WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $przedmiot = $_POST['przedmiot'];
    $temat = $_POST['temat'];
    $data = $_POST['data'];

    $sql = "UPDATE tematy_lekcji SET przedmiot='$przedmiot', temat='$temat', data='$data' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Temat został zaktualizowany!";
    } else {
        echo "Błąd: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>

    <title>Edytuj temat</title>
    <?php include('head.php') ?>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include('header1.php')?>
    <h1>Edytuj temat lekcji</h1>
    <form method="POST">
        <label>Przedmiot:</label>
        <input type="text" name="przedmiot" value="<?= $row['przedmiot']; ?>"  readonly><br>
        <table class="unboard">
            <tr>
            <td>Temat:</td>
            <td><textarea  name="temat" value="" rows="5" cols="40" required><?= $row['temat']; ?></textarea><br></td>
            </tr>
        </table>
        <label>Data:</label>
        <input type="date" name="data" value="<?= $row['data']; ?>" required><br>

        <input class="przyc1" type="submit" value="Zaktualizuj temat">
    </form>
</body>
</html>