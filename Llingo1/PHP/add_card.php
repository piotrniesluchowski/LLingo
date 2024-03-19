<?php
// Połącz z bazą danych
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "llingo";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobierz dane z formularza
    $deckId = $_POST['deck_id'];
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    // Dodaj nową fiszkę do bazy danych
    $sql = "INSERT INTO cards (deck_id, question, answer) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $deckId, $question, $answer);
    $stmt->execute();
}

// Przekieruj ponownie do deck_details.php
header("Location: deck_details.php?deck_id=" . $deckId);
exit();
?>
