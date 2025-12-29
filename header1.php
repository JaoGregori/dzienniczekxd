<?php
include($korzen.'deep.php');
include($deep.'db_connect.php');
include($deep.'wersja_ob.php');

echo '
    <div id="header">
        <div id="imgh">
            <img id="ih" src="'.$deep.'icon.png" alt="LOGO">
        </div>
        <div id="lab_wer">
            Wersja dziennika '.$wersjad.'
        </div>
        <div id="prz">
            <a class="aph" href="'.$deep.'index.php"><button class="ph">Główna strona</button></a>
            <a class="aph" href="'.$deep.'oceny/oceny.php"><button class="ph">Oceny</button></a>
            <a class="aph" href="'.$deep.'obecnosci/obecnosci1.php"><button class="ph">Obecnosci</button></a>
            '//<a class="aph" href="'.$deep.'tematy/tematy.php"><button class="ph">Tematy lekcji</button></a>
            .'<a class="aph" href="'.$deep.'wersje.php"><button class="ph">Wersje dziennika</button></a>';
if ($_SESSION['uzytkownik'] < 13)
{
    echo '<a class="aph" href="'.$deep.'loginy/loginy.php"><button class="ph">Loginy w dzienniku</button></a>
            <a class="aph" href="'.$deep.'uczniowie/uczniowie.php"><button class="ph">Uczniowie</button></a>
            <a class="aph" href="'.$deep.'nauczyciele/nauczyciele.php"><button class="ph">Nauczyciele</button></a>
            </div>';
}
echo '      
            <div id="kontr"> Zalogowany jako: ';

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
    
    echo '  
            <a href="'.$deep.'wyloguj.php"><button class="ph">Wyloguj</button></a>
            </div>
        </div>
    </div>
    ';
    ?>