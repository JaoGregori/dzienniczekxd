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
    <title>Dodaj Ocenę</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <?php include('head.php') ?>
</head>
<body>

<br>
<div id="content">
    <h1>Dodaj Ocenę</h1>
    <form method="POST">
        <table>
            <tr><td>
        Uczeń: </td><td>
        <?php 
         include('db_connect.php');
        $sql = "SELECT uczniowie.id, uczniowie.imie, uczniowie.nazwisko FROM uczniowie ORDER BY klasa";
         $result = $conn->query($sql); 
         
         echo '<select name="idu" id="idu">';
    while ($row = $result->fetch_assoc())
    {
    
echo '<option value="'.$row["id"].' " selected>'.$row["imie"].' '.$row['nazwisko'].'</option>';

    }
    echo '</select></td></tr><tr><td> Przedmiot:</td>';    
    echo '<td><select name="przedmiot" id="przedmiot">';
    
    $sql = "SELECT przedmiot FROM przedmioty;";
    $result = $conn->query($sql);
   
    
    while ($row = $result->fetch_assoc())
    {
        echo '<option value="'.$row["przedmiot"].'">'.$row["przedmiot"].'</option>';
    }
    echo '</select>';
         ?>
        </td></tr><tr><td>
        Nauczyciel ID:</td><td>
        <input type="text" name="nauczyciel_id" value="1" required></td></tr><tr><td>
        Ocena:</td>
        <td>
        <select name="ocena">
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
        </select></td></tr><tr><td>
        Waga:</td><td>
        <input type="number" name="waga" required>
        </td></tr><tr><td>
        Do średniej:</td><td>
        <select name="dosredniej">
            <option value="1">Tak</option>
            <option value="0">Nie</option>
        </select>
        </td></tr><tr><td>
        Typ oceny:</td><td>
        <select name="typ">
            <option value="0">Zwykła</option>
            <option value="1">Semestralna</option>
        </select>
        </td></tr><tr><td>
        Okres:</td><td>
        <select name="okres" >
        <option value="2" selected>2</option><option value="1">1</option>
        </select>
        </td></tr><tr><td>
        Kolor:</td><td>
        <input type="color" name="kolor">
        </td></tr><tr><td>
        Komentarz:</td><td>
        <textarea name="komentarz" rows="5" cols="40"></textarea><br>
        <br>
        
            </select>
        <input name="submit1d" type="submit" value="Dodaj">
        </td></tr>
    </form>

    <?php
    // Dodawanie nowej oceny
        if (isset($_POST['submit1d'])){
        
    $uczen_id = $_POST['idu'];
    $nauczyciel_id = $_POST['nauczyciel_id'];
    $ocena = $_POST['ocena'];
    $okres = $_POST['okres'];
    $waga = $_POST['waga'];
    $dosredniej = $_POST['dosredniej'];
    $typ = $_POST['typ'];
    $komentarz = $_POST['komentarz'];
    $kolor = $_POST['kolor'];
    if ($kolor == "" || $kolor == "#000000") {
        $kolor = "#ffe4c4";
    }
   
    $przedmiot = $_POST['przedmiot']; 

        $sql = "INSERT INTO oceny (uczen_id, nauczyciel_id, ocena, okres, waga, dosredniej, typ, komentarz, data, czas, przedmiot, kolor)
        VALUES ('$uczen_id', '$nauczyciel_id', '$ocena', '$okres', '$waga', $dosredniej, '$typ', '$komentarz', CURRENT_DATE, CURRENT_TIME,  '$przedmiot', '$kolor');";

        if ($conn->query($sql)) {
            echo 'Ocena została dodana.
            ';
            echo "<script>window.opener.location.reload(); // Odśwież stronę 1
    window.close(); // Zamknij stronę 2</script>";
            exit();
        } else {
            echo "Błąd: " . $conn->error;
        } 
        $conn->close();
    }
    ?>
</div>
</body>
</html>
