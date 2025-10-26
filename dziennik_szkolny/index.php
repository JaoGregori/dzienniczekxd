<?php
session_start();

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
    <?php include('head.php') ?>
</head>
<body>
    <center><h1>Witaj w dzienniku szkolnym</h1></center><br>
    <div id="nl2"><img src="nl.png" id="nl" alt="Baba z bachorem uczy go ksiazeczki UwU"/></div><br>

    <div id="contg">
        
    
        <form method="POST" action="zaloguj.php">
            <table class="uklad">
            <tr class="uklad"><td class="uklad">Login: </td><td class="uklad"><input type="text" name="login" required><br></td></tr>
            <tr class="uklad"><td class="uklad">Hasło: </td><td class="uklad"><input type="password" name="haslo" required><br></td></tr>
            </table>
            <br>
            <center><input type="submit" class="przyc1" name="log" value="Zaloguj"></center>
            
        </form>
        <?php 
        if (isset($_SESSION['blad'])) {
            echo $_SESSION['blad'];
            unset($_SESSION['blad']);
        }
        ?>
    </div>
    
</body>
</html>