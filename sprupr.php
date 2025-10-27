<?php
if ($_SESSION['uzytkownik'] > 13)
{
    header('Location: bupr.php');
    exit();
}
?>