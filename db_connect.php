<?php
// Połączenie z bazą danych
$host = "db.fr-pari1.bengt.wasmernet.com";
$user = "2ecd8c60735880003a81557990ce";
$pass = "06952ecd-8c60-79ba-8000-41090a05b758";
$db = "dbN4zSt72x92xG3GvrYjYHXh";
$port = "10272";

$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}

