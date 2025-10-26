<?php
// Połączenie z bazą danych
$host = "localhost";
$user = "root";
$pass = "";
$db = "dziennik_szkolny";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}
?>