<?php
session_start(); // Wznawianie sesji

if (!isset($_SESSION["user_id"])) {
    // Jeśli użytkownik nie jest zalogowany, przekieruj go do strony logowania
    header("Location: index.html");
    exit();
}

// Pobieranie danych użytkownika i decków z bazy danych
$userId = $_SESSION["user_id"];

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

// Pobierz ilość decków użytkownika
$sql_deck_count = "SELECT COUNT(*) AS deck_count FROM Decks WHERE user_id = ?";
$stmt_deck_count = $conn->prepare($sql_deck_count);
$stmt_deck_count->bind_param("i", $userId);
$stmt_deck_count->execute();
$result_deck_count = $stmt_deck_count->get_result();
$row_deck_count = $result_deck_count->fetch_assoc();
$deck_count = $row_deck_count["deck_count"];

// Pobierz łączną liczbę fiszek użytkownika
$sql_total_cards = "SELECT COUNT(*) AS total_cards FROM Cards INNER JOIN Decks ON Cards.deck_id = Decks.deck_id WHERE Decks.user_id = ?";
$stmt_total_cards = $conn->prepare($sql_total_cards);
$stmt_total_cards->bind_param("i", $userId);
$stmt_total_cards->execute();
$result_total_cards = $stmt_total_cards->get_result();
$row_total_cards = $result_total_cards->fetch_assoc();
$total_cards = $row_total_cards["total_cards"];

// Zamknij połączenie z bazą danych
$stmt_deck_count->close();
$stmt_total_cards->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../CSS/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statystyki</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #070F2B;
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Ilość decków: <?php echo $deck_count; ?></p>
        <p>Łączna liczba fiszek: <?php echo $total_cards; ?></p>
    </div>
    <nav>
    <div class="nav-list">
        <a href=""><li>READING</li></a>
        <a href="../PHP/dashboard.php"><li>FLASHCARDS</li></a>
       <a href="../PHP/quiz.php"><li>QUIZ</li></a>
        <a href="../PHP/stats.php"><li>STATS</li></a>
    </div>
</nav>
</body>
</html>
