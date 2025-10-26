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
    <?php include('head.php') ?>
</head>
<body>
<div id="content">
<br><h1>Edytuj Ocenę</h1>
    <?php
    // Połączenie z bazą danych
    include('db_connect.php');

    // Pobieranie danych oceny
    //if (isset($_GET['id'])) {
        $idu = $_GET['idu'];
        $ido = $_GET['ido'];
    //}
    
    ?>

    <form action="edytuj_ocene.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $ido; ?>">
        <table>
            <tr><td>
        Uczeń: </td><td>
        <?php 
        
        $sql = "SELECT uczniowie.id, uczniowie.imie, uczniowie.nazwisko FROM uczniowie WHERE id='$idu'";
        $result = $conn->query($sql); 
         
        echo '<select name="uczen_id">';
        while ($row = $result->fetch_assoc())
        {
    
            echo '<option value="'.$row["id"].'">'.$row["imie"].' '.$row['nazwisko'].'</option>';

        }
        echo '</select> </td></tr><tr><td> Przedmiot:</td><td>';    
        echo '<select name="przedmiot">';
    
        $sql = "SELECT oceny.id, oceny.uczen_id, oceny.nauczyciel_id, oceny.ocena, oceny.okres, oceny.waga, oceny.dosredniej, oceny.typ, oceny.komentarz, oceny.data, oceny.czas, oceny.przedmiot, oceny.kolor, uczniowie.klasa, nauczyciele.imie, nauczyciele.nazwisko, uczniowie.imie AS 'imieu', uczniowie.nazwisko AS 'nazwiskou' 
                FROM oceny JOIN uczniowie ON oceny.uczen_id=uczniowie.id JOIN nauczyciele ON oceny.nauczyciel_id=nauczyciele.id WHERE oceny.id='$ido'";
        $result = $conn->query($sql);
   
    
        while ($row = $result->fetch_assoc())
        {
        echo '<option value="'.$row["przedmiot"].'">'.$row["przedmiot"].'</option>';
        ?>
        </select><br>
         </td></tr><tr><td>
        Nauczyciel</td><td>
        <select name="nauczyciel_id">
            <option value="<?= $row['nauczyciel_id']; ?>" required><?=$row['imie']?> <?=$row['nazwisko']?></option>
        </select><br>
        </td></tr><tr><td>
        Ocena:</td><td>
        <select name="ocena">
            <option value="<?=$row['ocena']?>"><?=$row['ocena']?></option>
            <option value="6.00">6</option>
            <option value="5.75">6-</option>
            <option value="5.50">5+</option>
            <option value="5.00">5</option>
            <option value="4.75">5-</option>
            <option value="4.50">4+</option>
            <option value="4.00">4</option>
            <option value="3.75">4-</option>
            <option value="3.50">3+</option>
            <option value="3.00">3</option>
            <option value="2.75">3-</option>
            <option value="2.50">2+</option>
            <option value="2.00">2</option>
            <option value="1.75">2-</option>
            <option value="1.50">1+</option>
            <option value="1.00">1</option>
            <option value="0.00">nb</option>
        </select><br>
        </td></tr><tr><td>
        Waga:</td><td>
        <input type="number" name="waga" value="<?= $row['waga']; ?>" required>
        </td></tr><tr><td>
        Licz do średniej:</td><td>
        <select name="dosredniej">
            <option value="1" <?= $row['dosredniej'] == 1 ? 'selected' : '' ?>>Tak</option>
            <option value="0" <?= $row['dosredniej'] == 0 ? 'selected' : '' ?>>Nie</option>
        </select>
        </td></tr><tr><td>
        Typ oceny: </td><td>
        <select name="typ">
            
            <option value="0" <?= $row['typ'] == 0 ? 'selected' : '' ?>>Zwykła</option>
            <option value="1" <?= $row['typ'] == 1 ? 'selected' : '' ?>>Okresowa</option>
        </select>
        </td></tr><tr><td>
        Okres:</td><td>
        <select name="okres">
            <?php include('okres.php');?>
        </select>
        </td></tr><tr><td>
        Kolor:</td><td>
        <input type="color" value="<?= $row['kolor'];?>" name="kolor">
        </td></tr><tr><td>
        Komentarz:</td><td>
        <textarea name="komentarz"><?= $row['komentarz']; ?></textarea>
        </td></tr><tr><td colspan="2">
        <input class="przyc1" type="submit" onclick="closeAndRefresh1()" value="Zapisz zmiany">
        
        <button class="przyc1" onclick="closeAndRefresh(<?= $ido ?>)">usun</button>
        
        <?php } ?>
    </form>
    

    <?php
    // Aktualizacja oceny
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $uczen_id = $_POST['uczen_id'];
        $nauczyciel_id = $_POST['nauczyciel_id'];
        $ocena = $_POST['ocena'];
        $waga = $_POST['waga'];
        $komentarz = $_POST['komentarz'];
        $data = $_POST['dataa'];
        $przedmiot = $_POST['przedmiot'];
        $dosredniej = $_POST['dosredniej'];
        $okres = $_POST['okres'];
        $typ = $_POST['typ'];
        $kolor = $_POST['kolor'];
    if ($kolor == "" || $kolor == "#000000") {
        $kolor = "#ffe4c4";
    }

        $sql = "UPDATE oceny SET uczen_id='$uczen_id', nauczyciel_id='$nauczyciel_id', ocena='$ocena', waga='$waga', dosredniej=$dosredniej, okres='$okres', typ='$typ',
                komentarz='$komentarz', `data`=CURRENT_DATE, czas=CURRENT_TIME, przedmiot='$przedmiot', kolor='$kolor' WHERE id='$id'";
        
        if ($conn->query($sql) === TRUE) {
            echo "Ocena została zaktualizowana.";
            echo "<script>window.opener.location.reload(); // Odśwież stronę 1
    window.close(); // Zamknij stronę 2</script>";
        } else {
            echo "Błąd: " . $conn->error;
        }
    }

    $conn->close();
    ?>
    </div>
    <script>
    function closeAndRefresh(c) {

    let stro1 = 'usun_ocene.php?id=' + c;
    let newTab = window.open(stro1, "_blank");
    window.opener.location.reload(); // Odśwież stronę 1
    window.close(); // Zamknij stronę 2
    }

    function closeAndRefresh1() {
    
    }
</script>
</body>
</html>
