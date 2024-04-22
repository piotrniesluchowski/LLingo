<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    // Użytkownik niezalogowany, zakończ działanie
    header("HTTP/1.1 401 Unauthorized");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sprawdź czy przesłano deck_id
    if (isset($_POST["deck_id"])) {
        $userId = $_SESSION["user_id"];
        $deckId = $_POST["deck_id"];

        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "llingo";

        $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

        // Sprawdzenie połączenia
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Sprawdź czy użytkownik jest właścicielem decka
        $checkOwnershipSql = "SELECT user_id FROM Decks WHERE deck_id = ? LIMIT 1";
        $checkOwnershipStmt = $conn->prepare($checkOwnershipSql);
        $checkOwnershipStmt->bind_param("i", $deckId);
        $checkOwnershipStmt->execute();
        $checkOwnershipResult = $checkOwnershipStmt->get_result();

        if ($checkOwnershipResult->num_rows > 0) {
            $ownershipRow = $checkOwnershipResult->fetch_assoc();

            if ($ownershipRow["user_id"] === $userId) {
                // Usuń deck
                $deleteSql = "DELETE FROM Decks WHERE deck_id = ?";
                $deleteStmt = $conn->prepare($deleteSql);
                $deleteStmt->bind_param("i", $deckId);
                $deleteStmt->execute();

                if ($deleteStmt->affected_rows > 0) {
                    // Deck usunięty pomyślnie
                    echo json_encode(["success" => true, "message" => "Deck został pomyślnie usunięty."]);
                } else {
                    // Błąd podczas usuwania decka
                    echo json_encode(["success" => false, "message" => "Wystąpił błąd podczas usuwania decka."]);
                }
            } else {
                // Użytkownik nie jest właścicielem decka
                echo json_encode(["success" => false, "message" => "Nie masz uprawnień do usunięcia tego decka."]);
            }
        } else {
            // Deck o podanym ID nie istnieje
            echo json_encode(["success" => false, "message" => "Deck o podanym ID nie istnieje."]);
        }

        $checkOwnershipStmt->close();
        $deleteStmt->close();
        $conn->close();
    } else {
        // Brak przekazanego deck_id
        echo json_encode(["success" => false, "message" => "Nieprawidłowe żądanie."]);
    }
} else {
    // Nieprawidłowa metoda żądania
    echo json_encode(["success" => false, "message" => "Nieprawidłowa metoda żądania."]);
}
?>
