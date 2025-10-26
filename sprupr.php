<?php
if ($_SESSION['uzytkownik'] != 1)
{
    header('Location: bupr.php');
    exit();
}
?>