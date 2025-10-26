<?php
// Połączenie z bazą danych
$host = "db.fr-pari1.bengt.wasmernet.com";
$user = "e12d0ed37cc080007a312aed9282";
$pass = "068fe12d-0ed4-75b2-8000-a97de9edb56c";
$db = "dbE6nbUDUQaDkyKvYHWMhGat";
$port = "10272";

$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}

?>


