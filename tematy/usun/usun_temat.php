<?php
$korzen = __DIR__."/";
include('deep.php');
session_start();

if (!isset($_SESSION['zalogowany']))
{
    header('Location: '.$deep.'index.php');
    exit();
}
include($deep.'sprupr.php');

include($deep.'db_connect.php');

$id = $_GET['id'];

$sql = "DELETE FROM tematy_lekcji WHERE id=$id";
if ($conn->query($sql) === TRUE) {
    header('Location: '.$deep.'tematy/tematy.php');
} else {
    echo "Błąd: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>