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
<!DOCTYPE html>
<html>
<head>
    <title>Dodaj Oceny Seryjnie</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?php echo $deep;?>style.css">
    <?php include($deep.'head.php') ?>
</head>
<body>
<div id="top">
<?php include($deep.'header1.php')?>
</div>
<div id="contener">
<div id="ContentPages">
    <div class="pageForm">
    <form method="POST">
    <div class="formItems">
    Wybierz klasę: 
    <select class="boxSmall" name="klasa">
        <?php 
        include($deep.'db_connect.php');
        $sql = "SELECT klasa FROM uczniowie;";
        $result = $conn->query($sql);
        $ostatnialk = NULL;
            while($row = $result->fetch_assoc()){
                if($row['klasa'] !== $ostatnialk) {
                echo '<option  value="'.$row['klasa'].'">'.$row['klasa'].'</option>';
                $ostatnialk = $row['klasa'];
            }} 
        ?>
    </select>
    </div>
    <input class="formButton" type="submit" value="Wybierz">
    </form>
    </div>
    
    <div id="pageFormSerialGrades">
    <form method="POST">
    <?php
    if(isset($_POST['klasa']))
{
        $klasa = $_POST['klasa'];
        $sql = "SELECT uczniowie.id, uczniowie.imie, uczniowie.nazwisko FROM uczniowie WHERE klasa = '$klasa';";
        $result = $conn->query($sql);
        echo '<div class="formItems">
         Waga:<input class="boxNum" type="number" name="waga" min="1" required></div>
        
        <div class="formItems">Do średniej:<select class="boxSelect" name="dosredniej">
            <option value="1">Tak</option>
            <option value="0">Nie</option>
        </select></div>
        
        <div class="formItems">Typ oceny:<select class="boxSelect" name="typ">
            <option value="0">Zwykła</option>
            <option value="1">Semestralna</option>
        </select></div>
        
        <div class="formItems">Okres:<select class="boxSelect" name="okres">
            <option value="2" selected>2</option><option value="1">1</option>
            
        </select></div>
        <div class="formItems">Przedmiot: <select class="boxSelect" name="przedmiot">';
        
        $sql1 = "SELECT przedmiot FROM przedmioty;";
        $result1 = $conn->query($sql1);
   
        while ($row1 = $result1->fetch_assoc())
        {
            echo '<option value="'.$row1["przedmiot"].'">'.$row1["przedmiot"].'</option>';
        }
        echo '</select></div>
        <div class="formItems">Kolor:<input type="color" name="kolor"></div>
        </div>
        <br>
        <div id="tabOS">
        <table>
        <tr><th>ID</th><th>Imię</th><th>Nazwisko</th><th>Ocena</th><th>Komentarz</th</tr>';
        while($row = $result->fetch_assoc())
        {
            echo '
        
            
            
        <tr><td><input type="hidden" name="id[]" value="'.$row['id'].'"></input>'.$row['id'].'</td><td>'.$row['imie'].'</td><td>'.$row['nazwisko'].'</td>
        <td><select name="ocena[]">
        <option value="">Wybierz ocenę</option>
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
        </select></td><td><textarea name="komentarz[]" rows="5" cols="40"></textarea></td></tr>
            ';
        }
        
        echo '</table>
        </div>
        <input class="formButton" type="submit" name="submit1" value="Dodaj oceny">';
        
}
    ?>
    </form>
    <?php
    if (isset($_POST['submit1'])) {
        $ids = $_POST['id'];
        $oceny = $_POST['ocena'];
        $komentarze = $_POST['komentarz'];

        $przedmiot = $_POST['przedmiot'];
        $waga = $_POST['waga'];
        $dosredniej = $_POST['dosredniej'];
        $typ = $_POST['typ'];
        $okres = $_POST['okres'];
        $kolor = $_POST['kolor'];
    if ($kolor == "" || $kolor == "#000000") {
        $kolor = "#ffe4c4";
    }
        
    
        for ($i = 0; $i < count($ids); $i++) 
        {
            $id = $ids[$i];
            $ocena = $oceny[$i];
            $komentarz = $komentarze[$i];
            if ($ocena !== '') {
            $sql2 = "INSERT INTO oceny (`uczen_id`, `nauczyciel_id`, `ocena`, `okres`, `typ`, `waga`, `dosredniej`, `komentarz`, `data`, `czas`, `przedmiot`, `kolor`) 
                                VALUES ('$id', '1', '$ocena', '$okres', '$typ', '$waga', $dosredniej, '$komentarz', CURRENT_DATE, CURRENT_TIME, '$przedmiot', '$kolor');";
            $conn->query($sql2);
            }else {
                echo '<br>Nie wybrano oceny dla ucznia o id: '.$id.' Ocena nie została dodana';
            }
            
        }
    }        
    ?>
</div>
</div>
</body>
</html>
