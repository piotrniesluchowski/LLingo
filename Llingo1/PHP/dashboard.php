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
    <link rel="stylesheet" href="../css/style.css">
    <title>Twoje decki</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            color: #FFF5E0;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column-reverse;
            justify-content: start;
            align-items: center;
            height: 100vh;
        }

        h3 {
            color: #FFF5E0;
        }

        .deck-container {
            position: relative;
            display: flex; 
            flex-direction: column;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 80px;

        }

        .deck {
            background-color: #41B06E;
            border-radius: 0 8px 8px 0px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 15px;
            text-align: center;
            width: 500px;
            position: relative;
            color: #FFF5E0;
        }

        .delete-button {
        position: absolute;
        top: 0;
        left: -25px;
        background-color: red;
        color: #FFF5E0;
        border: none;
        border-radius: 4px;
        padding: 5px;
        cursor: pointer;
        font-size: 12px;
        transition: background-color 0.3s ease;
        width: 25px;
        height: 55px
        }

        .delete-button:hover {
            background-color: #ff0000;
        }

        button {
            position: relative;
            top: 10px;
            background-color: #41B06E;
            color: #FFF5E0;
            padding: 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            width: 230px
        }

        button:hover {
            box-shadow: 0 0 10px #8DECB4;
        }
        .deck {
            cursor: pointer; /* Dodaj kursor wskazujący na to, że można kliknąć */
        }

        .wrapper{
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: row;

        }
        li{
            list-style-type: none;
            text-align: center;
        }
    </style>
</head>
<body>
    <button id='createDeckButton' type='button'>Utwórz deck</button>

<div class="deck-container">
    <?php
    while ($row = $result->fetch_assoc()) {



        echo "<div class='deck'>";
        echo $row["deck_name"];
        echo "<div style='width:100%;height:100%;' onclick='goToDeckDetails(" . $row["deck_id"] . ")'>";
        echo "</div>";
        echo "<button class='delete-button' onclick='deleteDeck(" . $row["deck_id"] . ")'>X</button>";
        echo "</div>";
    }
    ?>
</div>
<nav>
    <div class="nav-list">
        <a style="color: #FFF5E0;" href="../PHP/dashboard.php"><li>FLASHCARDS</li></a>
       <a style="color: #FFF5E0;" href="../PHP/quiz.php"><li>QUIZ</li></a>
        <a style="color: #FFF5E0;" href="../PHP/stats.php"><li>STATS</li></a>
    </div>
</nav>


    <?php
    $stmt->close();
    $conn->close();
    ?>

</body>
</html>
