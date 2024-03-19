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

// Pobierz decki użytkownika
$sql = "SELECT deck_id, deck_name FROM Decks WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
<script src="../JS/create_deck.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <title>Twoje decki</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap');
        body {
            font-family: 'lato', sans-serif;
            background-color: #070F2B;
            color: #9290C3;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h3 {
            color: #535C91;
        }

        .deck-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;

        }

        .deck {
            background-color: #1B1A55;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 15px;
            text-align: center;
            color: #535C91;
            width: 200px;
            position: relative;
        }

        .delete-button {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: #ff5252;
            color: #535C91;
            border: none;
            border-radius: 4px;
            padding: 5px;
            cursor: pointer;
            font-size: 12px;
            transition: background-color 0.3s ease;
        }

        .delete-button:hover {
            background-color: #ff0000;
        }

        button {
            background-color: #535C91;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #1B1A55;
            box-shadow: 0 0 10px #1B1A55;
        }
        .deck {
            cursor: pointer; /* Dodaj kursor wskazujący na to, że można kliknąć */
        }
        nav{
            width:100vw;
            height: 8vh;
            background: #535C91;
            position: fixed;
            flex-direction: row;
            bottom: 0;
            list-style-type: none;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .nav-list{
            width: 80%;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
        }
    </style>
</head>
<body>
    <button id='createDeckButton' type='button'>Utwórz deck</button>

<div class="deck-container">
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<div class='deck' onclick='goToDeckDetails(" . $row["deck_id"] . ")'>";
        echo "<button class='delete-button' onclick='deleteDeck()" . $row["deck_id"] . ")'>X</button>";
        echo $row["deck_name"];
        echo "</div>";
    }
    ?>
</div>
<nav>
    <div class="nav-list">
        <a href=""><li>READING</li></a>
        <a href="../PHP/dashboard.php"><li>FLASHCARDS</li></a>
       <a href="../PHP/quiz.php"><li>QUIZ</li></a>
        <a href="../PHP/stats.php"><li>STATS</li></a>
    </div>
</nav>


    <?php
    $stmt->close();
    $conn->close();
    ?>

</body>
</html>
