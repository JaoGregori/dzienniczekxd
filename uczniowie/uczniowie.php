<?php
$korzen = __DIR__."/";
include('deep.php');
include($deep.'session.php');

if (!isset($_SESSION['zalogowany']))
{
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Uczniowie</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" type="image/x-icon" href="../icon.png">
    <?php include('../head.php') ?>
</head>
<body>
</div id="top">
    <?php include('../header1.php')?>
</div>
<div id="contener">
    <div id="ContentPages">
        
        <h1>Lista uczniów</h1>
    <div class="pageForm">
        <form method="post" action="">
            
                <div class="formItems">
                    Wybierz klasę: <select class="boxSelect" name="klasaa">
                    <?php
                    $kod = NULL;
                    $sql = "SELECT DISTINCT uczniowie.klasa FROM uczniowie" ;
                    $result = $conn->query($sql);
                    $ostatnialk = NULL;
                    while($row = $result->fetch_assoc())
                    {
                        if($row['klasa'] !== $ostatnialk)
                        {
                            echo '<option  value="'.$row['klasa'].'"';
                            if(isset($_POST['klasaa']) && $_POST['klasaa'] == $row['klasa']){echo 'selected';}
                            echo'>'.$row['klasa'].'</option>';
                            $ostatnialk = $row['klasa'];
                        }
                    }?>
                    </select>
                </div>
                <input class="formButton" name="sub1" type="submit" value="Wybierz">
                <input class="formButton" name="sub2" type="submit" value="Wszyscy uczniowie">
            </form>
        <a href="dodaj/dodaj_ucznia.php"><button class="formButton">+ Dodaj nowego ucznia</button></a>
    </div>
        <?php
include('../db_connect.php');

// Pobieranie listy uczniów
if(isset($_POST['sub1']) || isset($_POST['sub2']))
    {
        if(isset($_POST['sub1']) && !isset($_POST['sub2']))
            {
                $classa = $_POST['klasaa'];
                $sql = "SELECT * FROM uczniowie WHERE klasa='$classa'";
            }else
            {
                $sql = "SELECT * FROM uczniowie";
            }
        echo '<div class="pageTable">
        <table>
        <tr>
            <th>ID</th>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>Klasa</th>
            <th>Data urodzin</th>
            <th>Miejscowosc</th>
            <th>Ulica</th>
            <th>Telefon</th>
            <th>Mail</th>
            <th>Akcje</th>
        </tr>';
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){ ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['imie']; ?></td>
            <td><?= $row['nazwisko']; ?></td>
            <td><?= $row['klasa']; ?></td>
            <td><?= $row['data_urodzin']; ?></td>
            <td><?= $row['miejscowosc']; ?></td>
            <td><?= $row['ulica']; ?></td>
            <td><?= $row['telef']; ?></td>
            <td><?= $row['mail']; ?></td>
            <td>
                <div class="actionTD">
                <a href="edytuj/edytuj_ucznia.php?id=<?= $row['id']; ?>"><button class="minwyb">Edytuj</button></a>
                <a href="usun/usun_ucznia.php?id=<?= $row['id']; ?>"><button class="minwyb">Usuń</button></a>
                <form method="POST" action="../oceny/oceny_s.php">
                    <input type="hidden" name="OUTidu" value="<?=$row['id'];?>">
                    <input class="minwyb" type="submit" name="sub" value="Oceny">
                </form>
                </div>
            </td>
        </tr>
        <?php }} ?>
    </table>
    </div>
        
    </div>
</div>
</body>
</html>

<?php
// $conn->close();
?>