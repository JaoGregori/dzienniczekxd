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
    $id = $_GET['id'];

    $sql = "UPDATE tematy_lekcji SET przedmiot='$przedmiot', temat='$temat', data='$data' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header('Location: '.$deep.'tematy/tematy.php');
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
    <?php include($deep.'head.php') ?>
    <link rel="stylesheet" href="<?php echo $deep;?>style.css">
</head>
<body>
<?php include($deep.'header1.php')?>
<div id="content">
    <h1>Edytuj temat lekcji</h1>
    <form method="POST">
        <?php
        $id = $_GET['id'];
        $sql = "SELECT * FROM tematy_lekcji WHERE id=$id";
        $result = $conn->query($sql); 
        while($row = $result->fetch_assoc()){
        ?>
        <table>
        <tr><td>Przedmiot:</td>
        <td><input type="text" name="przedmiot" value="<?=$row['przedmiot']?>"  readonly></td></tr>
        
            <tr>
            <td>Temat:</td>
            <td><textarea  name="temat" value="" rows="5" cols="40" required><?= $row['temat'] ?></textarea><br></td>
            </tr>
        
        <tr><td>Data:</td>
        <td><input type="date" name="data" value="<?= $row['data'] ?>" required></td></tr>
        </table>
        <input class="przyc1" type="submit" value="Zaktualizuj temat">
    </form>
    <?php }?>
</div>
</body>
</html>