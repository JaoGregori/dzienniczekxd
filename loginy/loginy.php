<?php
$korzen = __DIR__."/";
session_start();

if (!isset($_SESSION['zalogowany']))
{
    header('Location: ../index.php');
    exit();
}
include('../sprupr.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Loginy</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" type="image/x-icon" href="../icon.png">
    <?php include('../head.php');
    ?>
</head>
<body>

<?php include('../header1.php')?>
<?php include('../db_connect.php')?>
<div id="content">
    <br><br>
    <h1>Dodaj loginy uczniów i nauczycieli</h1>
    <br><br>
    <form method="POST">
        <table>
            <tr><td>Login: </td><td><input type="text" name="login" required><br></td></tr>
            <tr><td>Hasło: </td><td><input type="password" name="haslo" required><br></td></tr>
            <tr><td>id ucznia/nauczyciela: </td><td><input type="number" name="id" required><br></td></tr>
        </table>
        <center><input type="submit" name="log1" class="przyc1" value="Dodaj"></center>
    </form>
    <br>

    <?php
     if (isset($_POST['log1'])) {
        $login1 = $_POST['login'];
        $haslo1 = $_POST['haslo'];
        $id1 = $_POST['id'];
    
        $sql1 = "INSERT INTO loginy (login, haslo, sz_id) VALUES ('$login1', '$haslo1', '$id1')";
        
        if ($conn->query($sql1) === TRUE) {
            echo "Nowy login został dodany pomyślnie";
        } else {
            echo "<div title'".$sql." ".$conn->error."'>Błąd: login istnieje lub coś poszło nie tak</div>";
        }
    }
    $sql = "SELECT * FROM loginy";
    $result =$conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Login</th><th>Hasło</th><th>Opcje</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["sz_id"]."</td><td>".$row["login"]."</td><td>".$row["haslo"]."</td><td><button class='przyc1' onclick='openPage(".$row['uz_id'].")'>Edytuj</button></td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 wyników";
    }
   
    ?>
</div>
</body>
<script>
    function openPage(a, b) {
                let stro = 'edytuj/edytuj_loginy.php?uzid=' + a;
                let popup = window.open(stro, "popupWindow", "width=600,height=600")
                
            }
</script>