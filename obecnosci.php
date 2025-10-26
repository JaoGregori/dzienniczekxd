<?php
session_start();

if (!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}


?>
<?php
// Połączenie z bazą danych
$servername = "localhost";
$username = "root"; // Uzupełnij swoimi danymi
$password = ""; // Uzupełnij swoimi danymi
$dbname = "dziennik_szkolny";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sprawdzenie formularza
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uczen_id = $_POST['uczen_id'];
    $nauczyciel_id = $_POST['nauczyciel_id'];
    $data = date('Y-m-d'); // Używa dzisiejszej daty
    $godzina = date('H:i'); // Używa bieżącej godziny
    $status = $_POST['status'];

    $sql = "INSERT INTO obecnosci (uczen_id, nauczyciel_id, data, godzina, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisis", $uczen_id, $nauczyciel_id, $data, $godzina, $status);

    if ($stmt->execute()) {
        echo "Rejestracja obecności udana!";
    } else {
        echo "Błąd: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Obecności</title>
    <link rel="stylesheet" href="style.css">
    <?php include('head.php') ?>
</head>
<body>
<?php include('header1.php')?>
<br>
<br>
<form action="" method="POST" onsubmit="return: false">
        <label for="uczen_id">Uczniowie:</label>
        <select name="uczen_id" id="uczen_id">
            <?php
            $result = $conn->query("SELECT id, imie, nazwisko FROM uczniowie");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['imie'] . " " . $row['nazwisko'] . "</option>";
            }
            ?>
        </select>
        
        <label for="nauczyciel_id">Nauczyciele:</label>
        <select name="nauczyciel_id" id="nauczyciel_id">
            <?php
            $result = $conn->query("SELECT id, imie, nazwisko FROM nauczyciele");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['imie'] . " " . $row['nazwisko'] . "</option>";
            }
            ?>
        </select>

        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="ob">Obecny</option>
            <option value="nb">Nieobecny</option>
            <option value="sp">Spóźniony</option>
            <option value="zw">Zwolniony</option>
        </select>
        
        <input type="submit" value="Zatwierdź Obecność">
    </form>
</body>
</html>