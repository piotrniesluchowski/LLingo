<?php
session_start(); // Wznawianie sesji

if (!isset($_SESSION["user_id"])) {
    // Jeśli użytkownik nie jest zalogowany, przekieruj go do strony logowania
    header("Location: index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Przetwarzanie danych do utworzenia nowego decka
    $newDeckName = $_POST["newDeckName"];
    $userId = $_SESSION["user_id"];

    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "llingo";

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

    // Sprawdzenie połączenia
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Dodanie nowego decka do bazy danych
    $sql = "INSERT INTO Decks (user_id, deck_name) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $userId, $newDeckName);

    if ($stmt->execute()) {
        // Pomyślnie dodano nowy deck
        $response = array("success" => true, "message" => "Deck został pomyślnie utworzony!");
        echo json_encode($response);
        exit();
    } else {
        // Błąd podczas dodawania nowego decka
        $response = array("success" => false, "message" => "Błąd: " . $stmt->error);
        echo json_encode($response);
    }

    $stmt->close();
    $conn->close();
}
?>
