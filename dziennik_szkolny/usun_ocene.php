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
    $sql = "DELETE FROM oceny WHERE id='$id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Ocena została usunięta.";
    } else {
        echo "Błąd: " . $conn->error;
    }
}

// Przekierowanie z powrotem do listy ocen

echo "<script>window.close();</script>";
exit();

$conn->close();
?>
