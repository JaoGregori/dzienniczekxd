<?php
$korzen = __DIR__."/";
include('deep.php');
// Połączenie z bazą danych
include($deep.'db_connect.php');

session_start();

if (!isset($_SESSION['zalogowany']))
{
    header('Location: '.$deep.'index.php');
    exit();
}
include($deep.'sprupr.php');


// Usuwanie oceny
if (isset($_GET['idob'])) {
    $id = $_GET['idob'];
    $sql = "DELETE FROM obecnosci WHERE id='$id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Obecnosc została usunięta.";
    } else {
        echo "Błąd: " . $conn->error;
    }
}

// Przekierowanie z powrotem do listy ocen

echo "<script>window.close();</script>";
exit();

$conn->close();
?>
