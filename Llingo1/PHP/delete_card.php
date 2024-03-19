<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit();
}

$userId = $_SESSION["user_id"];

$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "llingo";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$cardId = $_POST['card_id'];

$sql = "DELETE FROM cards WHERE card_id = ? AND deck_id IN (SELECT deck_id FROM decks WHERE user_id = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $cardId, $userId);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(array('success' => true, 'message' => 'Fiszka została pomyślnie usunięta.'));
} else {
    echo json_encode(array('success' => false, 'message' => 'Nie udało się usunąć fiszki.'));
}

$stmt->close();
$conn->close();
?>
