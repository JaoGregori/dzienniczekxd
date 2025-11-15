<?php
session_start();

if (!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}
if ($_SESSION['uzytkownik'] > 13)
{
    $idu=$_SESSION['uzytkownik'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Moje obecności</title>
    <link rel="stylesheet" href="style.css">
    <?php include('head.php'); ?>
</head>
<?php include('header1.php')?>
<body>
<br>
<div id="content">
    
<div class="BarDOS">
    <form method="POST">
    Obecności od:
    <input type="date" name="dataOD">
    Obecności do:
    <input type="date" name="dataDO">
    <input type="submit" class="przyc1" name="wyb" value="Wybierz">
                   Lub Wybierz wszystkie daty:
    <input type="submit" class="przyc1" name="wsjo" value="Wszystkie daty">
    </form>
    </div>
    <br>
    <div id="tabOB">
    <table >
    <?php
       if(isset($idu) && isset($_POST['wyb']) || isset($_POST['wsjo']))
       {
            
            $dataOd=$_POST['dataOD'];
            $dataDo=$_POST['dataDO'];
            
            $sql = "SELECT DISTINCT id FROM uczniowie WHERE id=$idu";
            $result = $conn->query($sql);
            $ids = [];
            while($row=$result->fetch_assoc())
            {
                $ids[]= $row['id'];
            }

            if(isset($_POST['dataOD']) && isset($_POST['dataDO']) && isset($_POST['wyb']) )
            {
                $data1od = $_POST['dataOD'];
                $data1do = $_POST['dataDO'];
            }

            if(isset($_POST['wyb']))
            {
            $sql = "SELECT DISTINCT data FROM obecnosci WHERE data BETWEEN '".$dataOd."' AND '".$dataDo."' AND uczen_id='".$idu."';";
            $result = $conn->query($sql);
            $daty = [];
            while($row=$result->fetch_assoc())
            {
                $daty[]= $row['data'];
            }
            }else
            {
            $sql = "SELECT DISTINCT data FROM obecnosci WHERE uczen_id=$idu;";
            $result = $conn->query($sql);
            $daty = [];
            while($row=$result->fetch_assoc())
            {
                $daty[]= $row['data'];
            } 
            }

            $sql = "SELECT id AS 'idu', imie, nazwisko FROM uczniowie WHERE id = '".$idu."';";
            $result = $conn->query($sql);
            $uczniowie = [];
            while($row=$result->fetch_assoc())
            {
                $uczniowie[]= $row;
            }

            echo '<tr><th>ID</th><th>Imię</th><th>Nazwisko</th>';
            foreach ($daty as $data)
            {
                echo "<th>$data</th>";
            }
            echo '</tr>';
            

            foreach ($uczniowie as $uczen)
            {
                echo "<tr>";
                echo "<td>".$uczen['idu']."</td><td>".$uczen['imie']."</td><td>".$uczen['nazwisko']."</td>";
                $uidt = $uczen['idu'];

                foreach ($daty as $data)
                {
                    $sql1 = "SELECT nauczyciele.imie AS 'imieN', nauczyciele.nazwisko AS 'nazwN', obecnosci.id, obecnosci.data, obecnosci.godzina, obecnosci.status FROM obecnosci  
                    JOIN nauczyciele ON nauczyciele.id=obecnosci.nauczyciel_id WHERE obecnosci.uczen_id = '".$uidt."' AND data='".$data."';";
                    $result1 = $conn->query($sql1);
                    echo '<td><div class="obec0">';
                    while($row1 = $result1->fetch_assoc())
                    {
                        echo '<div class="obec1" onclick="openPage('.$row1['id'].')" style="background-color: ';
                        $statk = $row1['status'];
                        if($statk=="nb"){echo"#c47974";}elseif($statk=="sp"){echo "#c4ae74";}elseif($statk=="zw"){echo "#2d44b5";}
                        echo '" title="Data:'.$row1['data'].' '.$row1['godzina'].'
Nauczyciel: '.$row1['imieN'].' '.$row1['nazwN'].'">
                        <div class="obec2">'.$row1['status'].'</div></div>';
                    }
                    echo "</td>";
                }
                echo "</tr>";
                
            }
       }
    ?>
</table>
    </div>
</div>
<script>
            function openPage(a) {
                let stro = 'edytuj_ob.php?&idob=' + a;
                let popup = window.open(stro, "popupWindow", "width=600,height=600")
        }
        
    </script>
</body>
</html>