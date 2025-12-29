<?php
if ($_SESSION['uzytkownik'] > 13)
{
    header('Location: '.$deep.'bupr.php');
    exit();
}
?>