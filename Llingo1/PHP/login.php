<?php
session_start(); // Rozpoczęcie sesji

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Przetwarzanie danych logowania
    $username = $_POST["loginUsername"];
    $password = $_POST["loginPassword"];

    // Połączenie z bazą danych - zastąp danymi dostępowymi do swojej bazy
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "llingo";

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

    // Sprawdzenie połączenia
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Wyszukanie użytkownika w bazie danych
    $sql = "SELECT user_id, username, password_hash FROM Users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $db_username, $db_password);
        $stmt->fetch();

        // Sprawdzenie hasła
        if (password_verify($password, $db_password)) {
            // Pomyślne logowanie
            $_SESSION["user_id"] = $user_id; // Zapisanie user_id do sesji
            header("Location: dashboard.php"); // Przekierowanie do dashboardu
            exit();
        } else {
            // Nieprawidłowe hasło
            echo "Błąd logowania: Nieprawidłowe hasło.";
        }
    } else {
        // Brak użytkownika o podanej nazwie
        echo "Błąd logowania: Brak użytkownika o podanej nazwie.";
    }

    $stmt->close();
    $conn->close();
}
?>
