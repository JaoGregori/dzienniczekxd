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
    <meta charset="UTF-8" />
    <title>Obecności</title>
    <link rel="stylesheet" href="<?php echo $deep;?>style.css">
    <?php include($deep.'head.php');
    include($deep.'db_connect.php') ?>
</head>
<body>
<div id="top">
<?php include($deep.'header1.php')?>
</div>
<div id="contener">
<div id="ContentPages">
    <div class="pageForm">
    <form method="POST">
    Wybierz klasę: 
    <select class="boxSelect" name="klasa">
        <?php
        $sql = "SELECT DISTINCT klasa FROM uczniowie;";
        $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                if($row['klasa'] !== $ostatnialk) {
                echo '<option  value="'.$row['klasa'].'"';
                if(isset($_POST['klasa']) && $_POST['klasa'] == $row['klasa']){echo 'selected';}
                echo'>'.$row['klasa'].'</option>';
            }} 
        ?>
    </select>
    <input class="formButton" type="submit" name="zatw1" value="Wybierz">
    </form>
    </div>
    <?php
    if (isset($_POST['klasa']) || isset($_POST['dodaj_ob'])) {
        $klasa = $_POST['klasa'] ?? ''; // Pobierz wybraną klasę
        $sql = "SELECT id, imie, nazwisko FROM uczniowie WHERE klasa = '$klasa';";
        $result = $conn->query($sql);

        echo '<div id="tabOB">
        <table>
        <form method="POST">
        <input type="hidden" name="klasa" value="' . htmlspecialchars($klasa) . '"> <!-- Ukryte pole dla klasy -->
        <tr><th>ID</th><th>Imię</th><th>Nazwisko</th><th>Ob</th><th>Nb</th><th>Sp</th><th>Zw</th></tr>';

        while ($row = $result->fetch_assoc()) {
            echo '
            <tr>
                <td>' . $row['id'] . '</td>
                <td>' . $row['imie'] . '</td>
                <input type="hidden" name="ido[' . $row['id'] . ']" value="' . $row['id'] . '">
                <td>' . $row['nazwisko'] . '</td>
                <td><input type="radio" value="ob" name="status[' . $row['id'] . ']"></td>
                <td><input type="radio" value="nb" name="status[' . $row['id'] . ']"></td>
                <td><input type="radio" value="sp" name="status[' . $row['id'] . ']"></td>
                <td><input type="radio" value="zw" name="status[' . $row['id'] . ']"></td>
            </tr>';
        }

        echo '</table>
        </div>
        <input class="formButton" type="submit" name="dodaj_ob" value="Dodaj obecności">
        </form>';

        if (isset($_POST['dodaj_ob'])) {
            $ids = $_POST['ido'];
            $statusy = $_POST['status'];

            foreach ($ids as $id => $value) 
            {
                $status = $statusy[$id] ?? null; // Sprawdź, czy status został wybrany
                if ($status) {
                    $sql3 = "INSERT INTO obecnosci (`uczen_id`, `nauczyciel_id`, `data`, `godzina`, `status`) 
                             VALUES ('$id', '1', CURRENT_DATE, CURRENT_TIME, '$status');";
                    if ($conn->query($sql3) === TRUE) {
                        echo "Status obecności dla ucznia o ID $id został zapisany.<br>";
                    } else {
                        echo "Błąd: " . $conn->error . "<br>";
                    }
                } else {
                    echo "Nie wybrano obecności dla ucznia o ID $id.<br>";
                }
            }
        echo '<a href="'.$deep.'obecnosci/obecnosci1.php"><button class="przyc1">Powrót</button></a>';
        }
    }
    ?>
</div>
</div>
</body>
</html>