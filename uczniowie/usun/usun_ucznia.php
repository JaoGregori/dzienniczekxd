<?php
$korzen = __DIR__."/";
include('deep.php');
// Połączenie z bazą danych
include($deep.'db_connect.php');

include($deep.'session.php');

if (!isset($_SESSION['zalogowany']))
{
    header('Location: '.$deep.'index.php');
    exit();
}
include($deep.'sprupr.php');


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
header("Location: ".$deep."uczniowie/uczniowie.php");
exit();

$conn->close();
?>
