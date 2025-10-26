<?php
session_start();

if (!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}
include('sprupr.php');

?>
<!DOCTYPE html>
<html>
<head>
    <title>Edytuj Loginy</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <?php include('head.php'); include('db_connect.php'); ?>
</head>
<body>
    <br/><br/>
<div id="content">
    <form action="edytuj_loginy.php" method="POST">
        
        <table>
            <input type="hidden" name="uzid" value="<?php echo $_GET['uzid']; ?>">
            <tr><td>Edycja:</td><td>
            <?php 
            $uzid = $_GET['uzid'];    
            $sql = "SELECT * FROM loginy WHERE uz_id='$uzid'";
            $result = $conn->query($sql); 
            
            
            while ($row = $result->fetch_assoc())
            {
                echo '<table>
            <tr><td>Login: </td><td><input type="text" name="login" value="'.$row['login'].'" required><br></td></tr>
            <tr><td>Hasło: </td><td><input type="password" name="haslo" value="'.$row['haslo'].'" required><br></td></tr>
            <tr><td>id ucznia/nauczyciela: </td><td><input type="number" name="id" value="'.$row['sz_id'].'" required><br></td></tr>
        </table>';

            }
            echo '</td></tr>';
            
            ?>
            
            
            </td></tr>
        </table>
        <input type="submit" name="zatw4" class="przyc1" value="Zapisz"> <button type="button" class="przyc1" onclick="closeAndRefresh(<?php echo $_GET['uzid']; ?>)">Usuń</button>
    </form>
    <?php

            if(isset($_POST['zatw4']))
            {
                $login = $_POST['login'];
                $haslo = $_POST['haslo'];
                $szid = $_POST['id'];
                $uzid = $_POST['uzid'];
                $sql1 = "UPDATE loginy SET `login`='$login', `haslo`='$haslo', `sz_id`='$szid' WHERE `uz_id`='$uzid'";
                
                if ($conn->query($sql1) === TRUE) {
                    echo "<script>window.opener.location.reload(); 
    window.close(); </script>";
                    echo 'w';
                } else {
                    echo "Wystąpił błąd podczas aktualizacji oceny: " . $conn->error . "";
                }
            }

    ?>
</div>
    <script>
    function closeAndRefresh(c) {

    let stro1 = 'usun_login.php?uzid=' + c;
    let newTab = window.open(stro1, "_blank");
    window.opener.location.reload(); // Odśwież stronę 1
    window.close(); // Zamknij stronę 2
    }

    function closeAndRefresh1() {
    
    }
</script>
</body>
</html>