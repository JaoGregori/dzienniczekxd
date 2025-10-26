<?php

session_start();

if (!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}
include('sprupr.php');

include('db_connect.php');

$id = $_GET['id'];

$sql = "DELETE FROM tematy_lekcji WHERE id=$id";
if ($conn->query($sql) === TRUE) {
    echo "Temat został usunięty!";
} else {
    echo "Błąd: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>