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
