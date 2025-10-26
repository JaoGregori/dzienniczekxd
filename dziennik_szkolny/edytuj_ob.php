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
    <title>Edytuj Ocenę</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <?php include('head.php'); include('db_connect.php'); ?>
</head>
<body>
    <br/><br/>
<div id="content">
    <form action="edytuj_ob.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $_GET['idob']; ?>">
        <table>
            <tr><td>Uczeń:</td><td>
            <?php 
            
            $sql = "SELECT obecnosci.id, obecnosci.status, obecnosci.data, obecnosci.godzina, uczniowie.imie, uczniowie.nazwisko FROM obecnosci JOIN uczniowie ON obecnosci.uczen_id=uczniowie.id WHERE obecnosci.id='".$_GET['idob']."'";
            $result = $conn->query($sql); 
            
            
            while ($row = $result->fetch_assoc())
            {
                echo '<input name="idob1" type="hidden" value="'.$row['id'].'"/><input disabled type="text" value="'.$row["imie"].' '.$row['nazwisko'].'"/>
                <tr><td>Data:</td><td><input type="date" value="'. $row['data'].'" disabled><input type="time" value="'. $row['godzina'].'" disabled></td></tr>
                <tr><td>Status:</td><td>
                <select name="status">
                    <option value="ob"';
                    if($row['status'] == 'ob') {echo ' selected';}
                    echo '>Obecny</option>
                    <option value="nb"';
                    if($row['status'] == 'nb') {echo ' selected';}
                    echo '>Nieobecny</option>
                    <option value="sp"';
                    if($row['status'] == 'sp') {echo ' selected';}
                    echo '>Spóźniony</option>
                    <option value="zw"';
                    if($row['status'] == 'zw') {echo ' selected';}
                    echo '>Zwolniony</option>
                </select>';

            }
            echo '</td></tr>';
            
            ?>
            
            
            </td></tr>
        </table>
        <input type="submit" name="zatw4" class="przyc1" value="Zapisz"> <button type="button" class="przyc1" onclick="closeAndRefresh(<?php echo $_GET['idob']; ?>)">Usuń</button>
    </form>
    <?php

            if(isset($_POST['zatw4']))
            {
                $stat = $_POST['status'];
                $idob = $_POST['idob1'];
                $sql1 = "UPDATE obecnosci SET `status`='".$stat."' WHERE `id`='".$idob."'";
                if ($conn->query($sql1) === TRUE) {
                    echo "<script>window.opener.location.reload(); 
    window.close(); </script>";
                } else {
                    echo "Wystąpił błąd podczas aktualizacji oceny: " . $conn->error . "";
                }
            }

    ?>
</div>
    <script>
    function closeAndRefresh(c) {

    let stro1 = 'usun_ob.php?idob=' + c;
    let newTab = window.open(stro1, "_blank");
    window.opener.location.reload(); // Odśwież stronę 1
    window.close(); // Zamknij stronę 2
    }

    function closeAndRefresh1() {
    
    }
</script>
</body>
</html>