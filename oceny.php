<?php
session_start();

if (!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}
if ($_SESSION['uzytkownik']!=1)
{
    header('Location: oceny_s.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Oceny</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <?php include('head.php');
    ?>
</head>
<body>

<?php include('header1.php')?>
<?php include('db_connect.php')?>
<div id="content">
<br><h1>Lista Ocen</h1>
    <div class="minwy">
<?php
if ($_SESSION['uzytkownik'] == 1)
{
    echo '
    <button onclick="openPage1()" class="minwyb">Dodaj nową ocenę</button>
    <a class="minwyba" href="dodaj_ocene_s.php"><button class="minwyb">Dodaj nową ocenę Seryjnie</button></a>';
}
    echo '<a class="minwyba" href="oceny_s.php"><button class="minwyb">Zobacz konkretne oceny ucznia</button></a>
    </div>';
    ?>
    <br>
    
    <div id="ocenygl">
        <div class="BarDOS">
        <form method="post" action="" >

            Wybierz klasę: <select name="klasaa">
            <?php
            $kod = NULL;
            $sql = "SELECT DISTINCT uczniowie.klasa FROM uczniowie" ;
            $result = $conn->query($sql);
            $ostatnialk = NULL;
            while($row = $result->fetch_assoc()){
                if($row['klasa'] !== $ostatnialk) {
                echo '<option  value="'.$row['klasa'].'">'.$row['klasa'].'</option>';
                $ostatnialk = $row['klasa'];
            }} ?>

            </select>
            Wybierz przedmiot: <select name="przedm">
            <?php 
            $sql = "SELECT przedmiot FROM przedmioty" ;
            $result = $conn->query($sql);
            $ostatniapr = NULL;
            while($row = $result->fetch_assoc()){
                if($row['przedmiot'] !== $ostatniapr) {
                echo '<option  value="'.$row['przedmiot'].'">'.$row['przedmiot'].'</option>';
                $ostatniapr = $row['przedmiot'];
            }} ?>
            </select>

            <input name="socen" type="submit" class="przyc1" value="Sprawdź oceny">
            
        </form>
        </div>
    </div>
    <br>
    <?php 
    if(isset($_POST['socen']))
    {
    $przedm = $_POST['przedm'];
    $klass = $_POST['klasaa'];
    echo '<h2>'.$przedm.' Klasa: ';
    echo $klass.'</h2>';
    }
    ?>
    
    <table name="Tabela ocenek" alt="Tabela ocenek">
        <tr>
            
            <th>ID</th>
            <th>Imię i nazwisko</th>
            <th>Ocena S.I</th>
            <th class="sred">Średnia za okres I</th>
            <th class="sred">Śródroczna</th>
            <th>Ocena S. II</th>
            <th class="sred">Średnia za okres II</th>
            <th class="sred">Roczna</th>

        </tr>
        <?php
        
        
        // Pobieranie listy ocen
        if(isset($_POST['socen']))
    {
            $przedm = $_POST['przedm'];
            $klass = $_POST['klasaa'];
            $sql = "SELECT oceny.id, oceny.uczen_id, oceny.nauczyciel_id, oceny.ocena, oceny.okres, oceny.waga, oceny.dosredniej, oceny.komentarz, oceny.data, oceny.czas, oceny.przedmiot, uczniowie.klasa, nauczyciele.imie, nauczyciele.nazwisko, uczniowie.imie AS 'imieu', uczniowie.nazwisko AS 'nazwiskou' 
            FROM oceny JOIN uczniowie ON oceny.uczen_id=uczniowie.id JOIN nauczyciele ON oceny.nauczyciel_id=nauczyciele.id WHERE uczniowie.klasa='$klass' AND oceny.przedmiot='$przedm'" ;
            $result = $conn->query($sql);
            $ostatniaos = NULL;
            
        while($row = $result->fetch_assoc())
        { 
            if($row['uczen_id'] !== $ostatniaos) 
            {?>
            <tr>
                <td><?=$row['uczen_id']?></td>
                <td><?=$row['imieu']?> <?=$row['nazwiskou']?></td>
                <td><div class="ocenka5"><?php
            
                $iducz = $row['uczen_id'];
                $sql21 = "SELECT oceny.id, oceny.uczen_id, oceny.nauczyciel_id, oceny.ocena, oceny.okres, oceny.waga, oceny.dosredniej, oceny.komentarz, oceny.data, oceny.czas, oceny.kolor, nauczyciele.imie, nauczyciele.nazwisko 
                FROM oceny JOIN uczniowie ON oceny.uczen_id=uczniowie.id JOIN nauczyciele ON oceny.nauczyciel_id=nauczyciele.id WHERE oceny.przedmiot='$przedm' AND oceny.uczen_id='$iducz' AND typ='0' AND okres='1'";
                $result123 = $conn->query($sql21);
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
                    <div class="ocenka" style="background-color:'.$row['kolor'].'"><a class="ocenka2" ><div class="ocenka3" 
                    >'.$row['ocena'].
                    '</div></a></div></div>';
                   
                }
            
                ?></div></td>
                <td><?php 
                    $sql211 = "SELECT ocena, waga FROM oceny WHERE przedmiot='$przedm' AND uczen_id='$iducz' AND dosredniej='1' AND okres='1'";       
                    $result211 = $conn->query($sql211);
                    $wazonasum = 0;
                    while($row211 = $result211->fetch_assoc())
                    {
                        $wazona = $row211['ocena'] * $row211['waga'];
                        $wazonasum = $wazonasum + $wazona;
                    }
                    $sql212 = "SELECT SUM(waga) AS sumwaga FROM oceny WHERE przedmiot='$przedm' AND uczen_id='$iducz' AND dosredniej='1' AND okres='1'";
                    $result212 = $conn->query($sql212);
                    while($row212 = $result212->fetch_assoc())
                    {
                        $sumwaga = $row212['sumwaga'];
                    }
                    if ($sumwaga > 0)
                    {
                    echo '<div class="sredniaw">'.round($wazonasum/$sumwaga, 2).'</div>';
                    }else
                    {
                        echo '<div class="sredniaw">0</div>';
                    }
                    
                
                ?></td>
                <td>
                    <?php
                    $sql213 = "SELECT id, uczen_id, ocena, kolor FROM oceny WHERE przedmiot='$przedm' AND uczen_id='$iducz' AND okres='1' AND typ='1'";
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
                FROM oceny JOIN uczniowie ON oceny.uczen_id=uczniowie.id JOIN nauczyciele ON oceny.nauczyciel_id=nauczyciele.id WHERE oceny.przedmiot='$przedm' AND oceny.uczen_id='$iducz' AND typ='0' AND okres='2'";
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
                    $sql221 = "SELECT ocena, waga FROM oceny WHERE przedmiot='$przedm' AND uczen_id='$iducz' AND dosredniej='1' AND okres='2'";       
                    $result221 = $conn->query($sql221);
                    $wazonasum1 = 0;
                    
                    
                    while($row221 = $result221->fetch_assoc())
                    {
                        $wazona1 = $row221['ocena'] * $row221['waga'];
                        $wazonasum1 = $wazonasum1 + $wazona1;
                    }
                    $sql222 = "SELECT SUM(waga) AS sumwaga FROM oceny WHERE przedmiot='$przedm' AND uczen_id='$iducz' AND dosredniej='1' AND okres='2'";
                    $result222 = $conn->query($sql222);
                    while($row222 = $result222->fetch_assoc())
                    {
                        $sumwaga1 = $row222['sumwaga'];
                    }
                    if ($sumwaga1 > 0)
                    {
                    echo '<div class="sredniaw">'.round($wazonasum1/$sumwaga1, 2).'</div>';
                    }else
                    {
                        echo '<div class="sredniaw">0</div>';
                    }

                
                ?></td>
                <td>
                    <?php
                    $sql223 = "SELECT id, uczen_id, ocena, kolor FROM oceny WHERE przedmiot='$przedm' AND uczen_id='$iducz' AND okres='2' AND typ='1'";
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
    <?php   $ostatniaos = $iducz;
            }
        }
    } ?>
    </table>
    
        </div>
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
                let stro = 'edytuj_ocene.php?idu=' + a + '&ido=' + b;
                let popup = window.open(stro, "popupWindow", "width=600,height=600")
        }
        function openPage1() {
                let stro = 'dodaj_ocene.php';
                let popup = window.open(stro, "popupWindow", "width=600,height=600")
        }
        
    </script>
</body>
</html>


<?php
if (isset($_POST['odsw'])){
for($r=0 ; $r=1 ; $r++)
{
    header("Refresh:1");
}
}        
// $conn->close();
?>
