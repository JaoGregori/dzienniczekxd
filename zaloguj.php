<?php
include('db_connect.php');
include($deep.'session.php');
if ((!isset($_POST['login'])) || (!isset($_POST['haslo']))){
    header('Location: index.php');
    exit();
}

$login = $_POST['login'];
$haslo = $_POST['haslo'];

$login = htmlentities($login, ENT_QUOTES, "UTF-8");
$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");

$result = $conn->query(
sprintf("SELECT * FROM loginy WHERE login='%s' AND haslo='%s'",
mysqli_real_escape_string($conn, $login),
mysqli_real_escape_string($conn, $haslo)));
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['zalogowany'] = true;
    $_SESSION['uzytkownik'] = $row['sz_id'];
    unset($_SESSION['blad']);
    $result->close();
    header('Location: index12.php');
}else{
    $_SESSION['blad'] = '<span stytle="color:red">Błędny login lub hasło</span>';
    header('Location: index.php');
}
?>