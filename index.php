<?php
$korzen = __DIR__."/";
include('deep.php');
include($deep.'session.php');

if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == true) {
    header('Location: index12.php');
    exit();
}
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
<div id="contIndex">
    <div id="cont2Index">
        <center><h1>Witaj w dzienniku szkolnym</h1></center><br>
        <div id="nl3"><img src="images\nl.png" id="nl" alt="Baba z bachorem uczy go ksiazeczki UwU"/></div>
            <div id="formIndex">
            <form id="form1Index" method="POST" action="zaloguj.php">
                <div class="tabIndex">
                <table>
                    <tr><td>Login: </td><td><input class="box" type="text" name="login" required><br></td></tr>
                    <tr><td>Hasło: </td><td><input class="box" type="password" name="haslo" required><br></td></tr>
                </table>
                </div>
                <div id="logIndex">
                <?php 
                        if (isset($_SESSION['blad'])) {
                        echo $_SESSION['blad'];
                        unset($_SESSION['blad']);
                    }
                ?>
                </div>
                <input id="bttnIndex" type="submit" class="przyc1" name="log" value="Zaloguj">
            </form>
        
            </div>
    </div>
</div>  
</body>
</html>