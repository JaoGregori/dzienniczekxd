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


// Usuwanie nl
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM nauczyciele WHERE id='$id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Ocena została usunięta.";
        echo "<script>window.close();</script>";
    } else {
        echo "Błąd: " . $conn->error;
    }
}

// Przekierowanie z powrotem do listy ocen


exit();

$conn->close();
?>
