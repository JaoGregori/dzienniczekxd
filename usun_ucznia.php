<?php
// Połączenie z bazą danych
include('db_connect.php');

session_start();

if (!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}
include('sprupr.php');


// Usuwanie oceny
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM uczniowie WHERE id='$id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Uczen został usunięty.";
    } else {
        echo "Błąd: " . $conn->error;
    }
}

// Przekierowanie z powrotem do listy ocen
header("Location: uczniowie.php");
exit();

$conn->close();
?>
