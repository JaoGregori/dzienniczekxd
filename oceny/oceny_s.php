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
    <title>Oceny ucznia</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" type="image/x-icon" href="../icon.png">
    <?php include('../head.php') ?>
</head>
<body>
    <div id="top">
        <?php include('../header1.php');
        include('../db_connect.php');?>
    </div>
<div id="contener">
    <div id="ContentPages">
        <h1>Oceny ucznia</h1>
        <?php 
            if ($_SESSION['uzytkownik'] < 13)
            {
                if(isset($_POST['OUTidu']))
                    {
                        $iducz = $_POST['OUTidu'];
                    }
        ?>
            <div id="ocenygl">
                <form method="post" action="">
                    <div class="pageForm">
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
                        <div class="formItems">
                            <?php 
                            if(isset($_POST['sub1']))
                            {
                                $klasaFORM = $_POST['klasaa'];
                                echo 'Wybierz ucznia: <select class="boxSelect" name="idu">';
                                $sql = "SELECT imie, nazwisko, id FROM uczniowie WHERE klasa=$klasaFORM" ;
                                $result = $conn->query($sql);
                                $ostatniapr = NULL;

                                while($row = $result->fetch_assoc())
                                {
                                    echo '<option  value="'.$row['id'].'"';
                                    if(isset($_POST['idu']) && $_POST['idu'] == $row['id']){echo 'selected';}
                                    echo '>'.$row['imie'].' '.$row['nazwisko'].'</option>';
                                }
                            } ?>
                            </select>
                        </div>
                <input class="formButton" name="sub1" type="submit" value="Sprawdź oceny">
            </div>
        </form>
    </div>
        <?php
            }else
            {
                if(isset($_POST['OUTidu']))
                    {
                        $iducz = $_POST['OUTidu'];
                    }else
                    {
                        $iducz = $_SESSION['uzytkownik'];
                    }
            }
            if (isset($_POST['sub1']) && isset($_POST['idu']) || isset($iducz))
            {   
                if  (isset($_POST['sub1']))
                {
                    $iducz = $_POST['idu'];
                }
    
    
        ?>
    <div class="pageTable">
        <center><h2><?php 
        $sql1 = "SELECT imie, nazwisko
        FROM uczniowie 
        WHERE id ='$iducz'";
        $result1 = $conn->query($sql1);
        while ($row1 = $result1->fetch_assoc())
        {
            echo $row1['imie'].' '.$row1['nazwisko'];
        }
        ?>
        </h2></center>
    <table>
        <tr><th>Przedmiot</th><th>Oceny S.I</th><th>Średnia</th><th>Ocena Śródroczna</th><th>Oceny S.II</th><th>Średnia</th><th>Ocena Roczna</th></tr>
        <?php
        $sql = "SELECT uczniowie.id, uczniowie.imie, uczniowie.nazwisko, oceny.przedmiot
        FROM uczniowie 
        JOIN oceny ON uczniowie.id = oceny.uczen_id
        WHERE uczniowie.id ='$iducz'
        Group by oceny.przedmiot";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc())
        {
            $przedmiot = $row['przedmiot'];
            $iducz = $row['id'];
            echo '<tr><td>'.$przedmiot.'</td><td><div class="ocenka5">';
            $sql52 = "SELECT oceny.id, oceny.uczen_id, oceny.nauczyciel_id, oceny.ocena, oceny.okres, oceny.waga, oceny.dosredniej, oceny.komentarz, oceny.data, oceny.czas, oceny.przedmiot, oceny.kolor, uczniowie.klasa, nauczyciele.imie, nauczyciele.nazwisko, uczniowie.imie AS 'imieu', uczniowie.nazwisko AS 'nazwiskou' 
            FROM oceny JOIN uczniowie ON oceny.uczen_id=uczniowie.id JOIN nauczyciele ON oceny.nauczyciel_id=nauczyciele.id WHERE oceny.uczen_id='$iducz' AND oceny.przedmiot='$przedmiot' AND oceny.okres='1'"; ;
            $result52 = $conn->query($sql52);
            $ostatniaos = NULL;
            
            while($row52 = $result52->fetch_assoc())
            {
                $lds=$row52['dosredniej'];
                $ldsp= NULL;
                if($lds==1){$ldsp='Tak';}elseif($lds==0){$ldsp='Nie';}
                echo '<div class="ocenka4" onclick="openPage('.$row52['uczen_id'].','.$row52['id'].')" title="Data: '.$row52['data'].' '.$row52['czas'].' 
Dodał/a: '.$row52['imie'].' '.$row52['nazwisko'].' 
Licz do średniej: '.$ldsp.' 
Waga: '.$row52['waga'].' 
Komentarz: '.$row52['komentarz'].'">
                <div class="ocenka" style="background-color:'.$row52['kolor'].'"><a class="ocenka2" ><div class="ocenka3" 
                >'.$row52['ocena'].
                '</div></a></div></div>';
            }

            ?></div></td>
            <td><?php 
                $sql211 = "SELECT ocena, waga FROM oceny WHERE przedmiot='$przedmiot' AND uczen_id='$iducz' AND dosredniej='1' AND okres='1'";       
                $result211 = $conn->query($sql211);
                $wazonasum = 0;
                while($row211 = $result211->fetch_assoc())
                {
                    $wazona = $row211['ocena'] * $row211['waga'];
                    $wazonasum = $wazonasum + $wazona;
                }
                $sql212 = "SELECT SUM(waga) AS sumwaga FROM oceny WHERE przedmiot='$przedmiot' AND uczen_id='$iducz' AND dosredniej='1' AND okres='1'";
                $result212 = $conn->query($sql212);
                while($row212 = $result212->fetch_assoc())
                {
                    $sumwaga = $row212['sumwaga'];
                }
                if ($sumwaga > 0 )
                    {
                        echo '<div name="sr" class="sredniaw">'.round($wazonasum/$sumwaga, 2).'</div>
                        <input type="hidden" name="sred1" value="'.round($wazonasum/$sumwaga, 2).'">';
                    }else
                    {
                        echo '<div class="sredniaw">0</div>';
                    }
                
            
            ?></td>
            <td>
                <?php
                $sql213 = "SELECT id, uczen_id, ocena, kolor FROM oceny WHERE przedmiot='$przedmiot' AND uczen_id='$iducz' AND okres='1' AND typ='1'";
                $result213 = $conn->query($sql213);
                if($result213->num_rows > 0)
                {
                    while($row213 = $result213->fetch_assoc())
                    {
                        echo '<div class="ocenka4"><div class="ocenka" onclick="openPage('.$row213['uczen_id'].','.$row213['id'].')" style="background-color:'.$row213['kolor'].'"><a class="ocenka2" >
                        <div class="ocenka3">'.$row213['ocena'].'</div></a></div></div>';
                    }
                }else{echo 'Brak oceny';}
                ?>
            </td>

            <? // SEMESTR II ?>

            <td><div class="ocenka5"><?php
            
            $sql21 = "SELECT oceny.id, oceny.uczen_id, oceny.nauczyciel_id, oceny.ocena, oceny.okres, oceny.waga, oceny.dosredniej, oceny.kolor, oceny.komentarz, oceny.data, oceny.czas, nauczyciele.imie, nauczyciele.nazwisko 
            FROM oceny JOIN uczniowie ON oceny.uczen_id=uczniowie.id JOIN nauczyciele ON oceny.nauczyciel_id=nauczyciele.id WHERE oceny.przedmiot='$przedmiot' AND oceny.uczen_id='$iducz' AND typ='0' AND okres='2'";
            $result123 = $conn->query($sql21);
            if($result123->num_rows > 0)
            {
                
            while($row = $result123->fetch_assoc())
            
            {   
               // echo '<div class="doc"><a href="dodaj_ocene.php?idu='.$row['uczen_id'].'">'.$row['ocena'].'</a></div>';
                $lds=$row['dosredniej'];
                $ldsp= NULL;
                if($lds==1){$ldsp='Tak';}elseif($lds==0){$ldsp='Nie';}
                echo '<div class="ocenka4" onclick="openPage('.$row['uczen_id'].','.$row['id'].')" title="Data: '.$row['data'].' '.$row['czas'].' 
Dodał/a: '.$row['imie'].' '.$row['nazwisko'].' 
Licz do średniej: '.$ldsp.' 
Waga: '.$row['waga'].' 
Komentarz: '.$row['komentarz'].'">
                <div class="ocenka" style="background-color:'.$row['kolor'].'"><a class="ocenka2"  
                ><div class="ocenka3" 
                >'.$row['ocena'].
                '</div></a></div></div>';
               
            }}else{echo '<div class="bo">Brak ocen</div>';}
        
            ?></div></td>
            <td><?php 
                $sql221 = "SELECT ocena, waga FROM oceny WHERE przedmiot='$przedmiot' AND uczen_id='$iducz' AND dosredniej='1' AND okres='2'";       
                $result221 = $conn->query($sql221);
                $wazonasum1 = 0;
                
                
                while($row221 = $result221->fetch_assoc())
                {
                    $wazona1 = $row221['ocena'] * $row221['waga'];
                    $wazonasum1 = $wazonasum1 + $wazona1;
                }
                $sql222 = "SELECT SUM(waga) AS sumwaga FROM oceny WHERE przedmiot='$przedmiot' AND uczen_id='$iducz' AND dosredniej='1' AND okres='2'";
                $result222 = $conn->query($sql222);
                while($row222 = $result222->fetch_assoc())
                {
                    $sumwaga1 = $row222['sumwaga'];
                }
                
                if ($sumwaga1 > 0)
                {
                echo '<div name="sr" class="sredniaw">'.round($wazonasum1/$sumwaga1, 2).'</div>
                <input type="hidden" name="sred2" value="'.round($wazonasum1/$sumwaga1, 2).'">';
                }else
                {
                    echo '<div class="sredniaw">0</div>';
                }
                
            
            ?></td>
            <td>
                <?php
                $sql223 = "SELECT id, uczen_id, ocena, kolor FROM oceny WHERE przedmiot='$przedmiot' AND uczen_id='$iducz' AND okres='2' AND typ='1'";
                $result223 = $conn->query($sql223);
                if($result223->num_rows > 0)
                {
                    while($row223 = $result223->fetch_assoc())
                    {
                        echo '<div class="ocenka4"><div class="ocenka" onclick="openPage('.$row223['uczen_id'].','.$row223['id'].')" style="background-color:'.$row223['kolor'].'"><a class="ocenka2" >
                        <div class="ocenka3">'.$row223['ocena'].'</div></a></div></div>';
                    }
                }else{echo 'Brak oceny';}
                ?>
            </td>
        </tr>
<?php   $ostatniaos = $przedmiot;
        }
    }
if(isset($_POST['idu']))
{
    echo ' <tr><td colspan="2">Średnia z ocen śródrocznych</td><td><div class="sredniaw"><div id="result"></div></div></td><td></td><td >Średnia z ocen II semestr</td><td><div class="sredniaw"><div id="result1"></div></div></td></tr>';
}
?>
 </table>
</div>
</div>
    </div>
</div>
</body>
<script>
        // Pobierz wszystkie elementy z klasą 'ocenka3'
        var elements = document.getElementsByClassName('ocenka3');
        
        for (var i = 0; i < elements.length; i++) {
            var value = parseFloat(elements[i].textContent);
            if (!isNaN(value)) {
                var integerPart = Math.floor(value);
                var decimalPart = value - integerPart;
                
                if (decimalPart === 0.00) {
                    elements[i].innerHTML = integerPart;
                } else if (decimalPart === 0.50) {
                    elements[i].innerHTML = integerPart + '+';
                } else if (decimalPart === 0.75) {
                    elements[i].innerHTML = (integerPart + 1) + '-';
                }

                if (integerPart === 0) {
                    elements[i].innerHTML = 'nb';
                }

                
            }
        }
        
        
    </script>
    <script>
            function openPage(a, b) {
                let stro = 'edytuj/edytuj_ocene.php?idu=' + a + '&ido=' + b;
                let popup = window.open(stro, "popupWindow", "width=600,height=600")
        }
        function openPage1() {
                let stro = 'dodaj/dodaj_ocene.php';
                let popup = window.open(stro, "popupWindow", "width=600,height=600")
        }
        
        
        const srednie = document.querySelectorAll('input[name="sred1"]');
        const wartosci = Array.from(srednie).map(input => parseFloat(input.value));
        console.log(wartosci);
        const srocen = wartosci.reduce((acc, val) => acc + val, 0) / wartosci.length;
        console.log(srocen);
        if (isNaN(srocen))
        {
            document.getElementById('result').innerHTML = '0';
        }else
        {
            document.getElementById('result').innerHTML = srocen.toFixed(2);
        }
        

        const srednie1 = document.querySelectorAll('input[name="sred2"]');
        const wartosci1 = Array.from(srednie1).map(input => parseFloat(input.value));
        console.log(wartosci1);
        const srocen1 = wartosci1.reduce((acc, val) => acc + val, 0) / wartosci1.length;
        console.log(srocen1);
        if (isNaN(srocen1))
        {
            document.getElementById('result1').innerHTML = '0';
        }else
        {
            document.getElementById('result1').innerHTML = srocen1.toFixed(2);
        }
    </script>
</html>

<?php
// $conn->close();
?>
