<?php
include('db_connect.php');

echo '
    <div id="header">
    <div id="imgh">
    <img id="ih" src="icon.png" alt="LOGO">
    Wersja dziennika <br> <center>0.6.2</center>
    </div>
    <div id="prz">
        <a href="index.php"><button class="ph">Główna strona</button></a>
        <a href="uczniowie.php"><button class="ph">Uczniowie</button></a> 
        <a href="nauczyciele.php"><button class="ph">Nauczyciele</button></a>
        <a href="oceny.php"><button class="ph">Oceny</button></a>
        <a href="obecnosci1.php"><button class="ph">Obecnosci</button></a>
        <a href="tematy.php"><button class="ph">Tematy lekcji</button></a>
        <a href="uwagi.php"><button class="ph" disabled>Uwagi</button></a>
        <a href="plan.php"><button class="ph" disabled>Plan lekcji</button></a>
        <a href="wersje.php"><button class="ph">Wersje dziennika</button></a>';
if ($_SESSION['uzytkownik'] == 1)
{
    echo '<a href="loginy.php"><button class="ph">Loginy w dzienniku</button></a>';
}
echo '</div>
    <div id="kontr"><a href="wyloguj.php"><button class="ph">Wyloguj</button></a> <div> Zalogowany jako: ';

    $idu = $_SESSION['uzytkownik'];
    $sql = "SELECT imie, nazwisko FROM uczniowie WHERE id='$idu'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
    {
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo $row['imie']." ". $row['nazwisko'];
    }else
    {
        $sql2 = "SELECT imie, nazwisko FROM nauczyciele WHERE id='$idu'";
        $result2 = $conn->query($sql2);
        $row = $result2->fetch_assoc();
        echo $row['imie']." ". $row['nazwisko'];
    }
    
    echo '</div></div>
    </div>
    ';
    ?>