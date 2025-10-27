<?php
session_start();

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
    <?php include('head.php') ?>
</head>
<body>
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
        echo "<center><h1>Witaj <div style='text-decoration: underline !important;'>". $row['imie']." ". $row['nazwisko']."</div> w dzienniku szkolnym</h1></center>";
    }

    ?>
    
    <div id="contg">
        <div class="puste"></div>
        <div id="gwyb">
        <a href="uczniowie.php"><button class="pg">Uczniowie</button></a> 
        <a href="nauczyciele.php"><button class="pg">Nauczyciele</button></a>
        <a href="oceny.php"><button class="pg">Oceny</button></a>
        <a href="tematy.php"><button class="pg">Tematy lekcji</button></a>
        <a href="uwagi.php"><button class="pg" disabled></button></a>
        <a href="plan.php"><button class="pg" disabled>Plan lekcji</button></a>
        <a href="obecnosci1.php"><button class="pg">Obecnosci</button></a>
        <a href="wersje.php"><button class="pg">Wersje dziennika</button></a>
        <a href="index.php"><button class="pg">Główna strona</button></a>
        </div>
        <div class="puste"></div><br><br>
       
    </div>
    <div id="nl2"><img src="images/nl.png" id="nl" alt="Baba z bachorem uczy go ksiazeczki UwU"/></div>
     Już niebawem - nowa szata graficzna oraz nowe funkcje!
</body>
</html>

<?php
//$conn->close();
?>