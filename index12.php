<?php
include('deep.php');
$korzen = __DIR__."/";
include($deep.'session.php');

if (!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}

include('db_connect.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dziennik Szkolny</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="icon.png">
    <?php include('head.php') ?>
</head>
<body>

    <div id="top">
        <?php include('header1.php');?>
    </div>
<div id="contener">
<div id="contentHP">
    <?php
    $idu = $_SESSION['uzytkownik'];
    $sql = "SELECT imie, nazwisko FROM uczniowie WHERE id='$idu'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
    {
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo "<center><h1>Witaj ". $row['imie']." ". $row['nazwisko']." w dzienniku szkolnym</h1></center>";
    }else
    {
        $sql2 = "SELECT imie, nazwisko FROM nauczyciele WHERE id='$idu'";
        $result2 = $conn->query($sql2);
        $row = $result2->fetch_assoc();
        echo "<center><h1>Witaj ". $row['imie']." ". $row['nazwisko']." w dzienniku szkolnym</h1></center>";
    }
    ?>
    <div id="contg">
        <div id="conttext">
            <h2 style="margin-top: 0px; font-size: 26px;">dzienniczekxd</h2>
            <p>
                <strong>dzienniczekxd</strong> to miejsce stworzone z myślą o prostym i wygodnym zarządzaniu szkolnymi informacjami — 
                ocenami, obecnościami oraz komunikacją między uczniami i nauczycielami. 
                Projekt powstał jako moja osobista inicjatywa i jednocześnie pełni funkcję mojego portfolio programistycznego.
            </p>
            <p>
                System został zaprojektowany tak, aby był szybki, intuicyjny i dostępny z każdego urządzenia. 
                Tworzę go samodzielnie jako 
                <strong>student Informatyki Ekonomicznej</strong>, stale rozwijając swoje kompetencje techniczne 
                i poszerzając wiedzę w zakresie systemów informatycznych, analityki oraz projektowania rozwiązań IT.
            </p>

            <h2 style="margin-top: 30px; font-size: 26px;">Cel projektu</h2>
    
            <p>
                Moim celem jest stworzenie funkcjonalnego narzędzia, które realnie ułatwia codzienną pracę w środowisku szkolnym. 
                W przyszłości planuję dodawać kolejne moduły, takie jak:
            </p>

            <ul style="margin-left: 25px; margin-bottom: 25px;">
                <li>rozszerzone statystyki ucznia,</li>
                <li>zaawansowany panel nauczyciela,</li>
                <li>system automatycznych powiadomień,</li>
                <li>większe opcje personalizacji.</li>
            </ul>

            <p>
                Dziękuję za korzystanie z dziennika i zapraszam do śledzenia kolejnych aktualizacji — projekt rozwijam na bieżąco 
                i traktuję jako ważną część mojego portfolio.
                </p>

        </div>  
        <div id="nl2">
            <img src="images/nl.png" id="nl" alt="Baba z bachorem uczy go ksiazeczki UwU"/>
        </div>     
    </div>   
</div>
</div>
</body>
</html>

<?php
//$conn->close();
?>