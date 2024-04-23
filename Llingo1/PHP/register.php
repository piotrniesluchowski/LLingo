<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Przetwarzanie danych rejestracji
    $username = $_POST["registerUsername"];
    $email = $_POST["registerEmail"];
    $password = password_hash($_POST["registerPassword"], PASSWORD_DEFAULT); // Haszowanie hasła

    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "llingo";

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

    // Sprawdzenie połączenia
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Wstawienie danych do bazy danych
    $sql = "INSERT INTO Users (username, email, password_hash) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);
    
    if ($stmt->execute()) {
        // Pomyślnie dodano użytkownika
        echo "Rejestracja zakończona sukcesem. Możesz się teraz zalogować.";
        // Przekierowanie do strony logowania
        header("Location: ../html/login.html");
        exit(); 
    } else {
        // Błąd podczas dodawania użytkownika
        echo "Błąd rejestracji: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
