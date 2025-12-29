<?php
$korzen = __DIR__."/";
include('deep.php');
include($deep.'db_connect.php');

include($deep.'session.php');

if (!isset($_SESSION['zalogowany']))
{
    header('Location: '.$deep.'index.php');
    exit();
}
include($deep.'sprupr.php');


// Usuwanie 
if (isset($_GET['uzid'])) {
    $id = $_GET['uzid'];
    $sql = "DELETE FROM loginy WHERE uz_id='$id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Login został usunięty.";
    } else {
        echo "Błąd: " . $conn->error;
    }
}

// Przekierowanie z powrotem do listy 

echo "<script>window.close();</script>";
exit();

$conn->close();
?>
