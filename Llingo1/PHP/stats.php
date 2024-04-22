<?php
session_start(); // Rozpoczęcie sesji

if (!isset($_SESSION["user_id"])) {
    // Jeśli użytkownik nie jest zalogowany, przekieruj go do strony logowania
    header("Location: index.html");
    exit();
}

// Pobranie danych użytkownika i decków z bazy danych
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

$sql_avg_cards_per_user = "SELECT AVG(cards_per_deck) AS avg_cards_per_user 
                           FROM (SELECT COUNT(card_id) AS cards_per_deck 
                                 FROM Decks 
                                 INNER JOIN Cards ON Decks.deck_id = Cards.deck_id 
                                 GROUP BY Decks.user_id) AS card_counts";
$result_avg_cards_per_user = $conn->query($sql_avg_cards_per_user);
$row_avg_cards_per_user = $result_avg_cards_per_user->fetch_assoc();
$avg_cards_per_user = $row_avg_cards_per_user["avg_cards_per_user"];

$sql_avg_cards_per_user = "SELECT AVG(cards_per_deck) AS avg_cards_per_user 
                           FROM (SELECT COUNT(card_id) AS cards_per_deck 
                                 FROM Decks 
                                 INNER JOIN Cards ON Decks.deck_id = Cards.deck_id 
                                 GROUP BY Decks.user_id) AS card_counts";

$sql_largest_deck = "SELECT deck_name, COUNT(card_id) AS card_count 
                     FROM Decks 
                     INNER JOIN Cards ON Decks.deck_id = Cards.deck_id 
                     WHERE Decks.user_id = ? 
                     GROUP BY Decks.deck_id 
                     ORDER BY card_count DESC 
                     LIMIT 1";

$stmt_largest_deck = $conn->prepare($sql_largest_deck);
$stmt_largest_deck->bind_param("i", $userId);
$stmt_largest_deck->execute();
$result_largest_deck = $stmt_largest_deck->get_result();

if ($result_largest_deck->num_rows > 0) {
    $row_largest_deck = $result_largest_deck->fetch_assoc();
    $largest_deck_name = $row_largest_deck["deck_name"];
    $largest_deck_count = $row_largest_deck["card_count"];
} else {
    $largest_deck_name = "Brak danych";
    $largest_deck_count = 0;
}

$stmt_largest_deck->close();


$sql_smallest_deck = "SELECT deck_name, COUNT(card_id) AS card_count 
FROM Decks 
INNER JOIN Cards ON Decks.deck_id = Cards.deck_id 
WHERE Decks.user_id = ? 
GROUP BY Decks.deck_id 
ORDER BY card_count ASC 
LIMIT 1";

// Zamknij połączenie z bazą danych
$stmt_deck_count->close();
$stmt_total_cards->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Statystyki</title>
    <style>
         @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100vw
        }
        .container{

        }
    </style>
</head>
<body>
<div class="container">
        <h1>Statystyki</h1>
        <h2>Ilość decków: <?php echo $deck_count; ?></h2>
        <h2>Łączna liczba fiszek: <?php echo $total_cards; ?></h2>
        <h2>Średnia liczba fiszek na talię: <?php echo round($avg_cards_per_user, 2); ?></h2>
        <h2>Największa talia: <?php echo $largest_deck_name; ?> (<?php echo $largest_deck_count; ?> fiszek)</h2>

    </div>
    <nav>
    <div class="nav-list">
        <a href="../PHP/dashboard.php"><li>FLASHCARDS</li></a>
       <a href="../PHP/quiz.php"><li>QUIZ</li></a>
        <a href="../PHP/stats.php"><li>STATS</li></a>
    </div>
</nav>
</body>
</html>
