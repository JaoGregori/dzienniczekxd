<?php
$korzen = __DIR__."/";
include('deep.php');
include($deep.'session.php');

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
<div id="top">
        <?php include('../header1.php')?>
</div>
<?php include('../db_connect.php')?>
<div id="contener">
<div id="ContentPages">
    <br><br>
    <h1>Dodaj loginy uczniów i nauczycieli</h1>
    <br><br>
    <div class="pageForm">
    <form method="POST">
        <div class="">
        <table>
            <tr><td>Login: </td><td><input style="height:23px !important" class="box" type="text" name="login" required><br></td></tr>
            <tr><td>Hasło: </td><td><input style="height:23px !important" class="box" type="password" name="haslo" required><br></td></tr>
            <tr><td>id ucznia/nauczyciela: </td><td><input class="boxSmall" style="height:23px !important" type="number" name="id" required><br></td></tr>
        </table>
        </div>
        <input type="submit" name="log1" class="przyc1" value="Dodaj">
    </form>
    </div>
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
        echo '<div id="tabOS"><table>';
        echo "<tr><th>ID</th><th>Login</th><th>Hasło</th><th>Opcje</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["sz_id"]."</td><td>".$row["login"]."</td><td>".$row["haslo"]."</td><td><button class='minwyb' onclick='openPage(".$row['uz_id'].")'>Edytuj</button></td></tr>";
        }
        echo "</table></div>";
    } else {
        echo "0 wyników";
    }
   
    ?>
</div>
</div>
</body>
<script>
    function openPage(a, b) {
                let stro = 'edytuj/edytuj_loginy.php?uzid=' + a;
                let popup = window.open(stro, "popupWindow", "width=600,height=600")
                
            }
</script>