<?php
// Pobierz deck_id z parametru w URL
$deckId = $_GET['deck_id'];

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

// Pobierz nazwę danego decka
$sqlDeck = "SELECT deck_name FROM decks WHERE deck_id = ?";
$stmtDeck = $conn->prepare($sqlDeck);
$stmtDeck->bind_param("i", $deckId);
$stmtDeck->execute();
$resultDeck = $stmtDeck->get_result();

// Pobierz fiszki dla danego decka
$sqlCards = "SELECT card_id, question, answer FROM cards WHERE deck_id = ?";
$stmtCards = $conn->prepare($sqlCards);
$stmtCards->bind_param("i", $deckId);
$stmtCards->execute();
$resultCards = $stmtCards->get_result();

while ($rowCard = $resultCards->fetch_assoc()) {
    echo "<div class='card'>";
    echo "<button class='delete-button-right' onclick='deleteCard($deckId, {$rowCard["card_id"]})'>X</button>";
    echo "<p>Pytanie: {$rowCard["question"]}</p>";
    echo "<p>Odpowiedź: {$rowCard["answer"]}</p>";
    echo "</div>";
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <script src="../JS/create_deck.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <title>Deck Details</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap');
        body {
            font-family: 'lato';
            background-color: #070F2B;
            color: #9290C3;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h3 {
            color: #535C91;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .card {
            display: flex;
            background-color: #1B1A55;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 15px;
            text-align: center;
            color: #9290C3;
            width: 200px;
        }

        form {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
            text-align: center;
        }

        input {
            padding: 10px;
        }

        button {
            background-color: #070F2B;
            color: #9290C3;
            padding: 10px 15px;
            margin-top: 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #535C91;
            box-shadow: 0 0 10px #535C91;
        }

.card {
    position: relative;
            background-color: #535C91;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 15px;
            display:flex;
            flex-direction: column;
            text-align: center;
            color: #fff;
            width: 200px;
            margin-bottom: 20px;
            float: bottom; /* Dodaj float: left, aby karty układały się obok siebie */
            margin-right: 20px; /* Dodaj odstęp między kartami */
}

.delete-button-right {
    position: absolute;
    top: 5px;
    right: 5px;
    background-color: #ff5252;
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 5px;
    cursor: pointer;
    font-size: 12px;
    transition: background-color 0.3s ease;
}

.delete-button-right:hover {
    background-color: #ff0000;
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
    <h3>Nazwa Decka: 
        <?php
        if ($rowDeck = $resultDeck->fetch_assoc()) {
            echo $rowDeck["deck_name"];
        }
        ?>
    </h3>

    <div class="card-container">
        <?php
        while ($rowCards = $resultCards->fetch_assoc()) {
            echo "<div class='card'>";
            echo "<strong>Pytanie:</strong> " . $rowCards["question"] . "<br>";
            echo "<strong>Odpowiedź:</strong> " . $rowCards["answer"];
            echo "</div>";
        }
        ?>
    </div>

    <form action="add_card.php" method="post">
        <label for="question">Pytanie:</label>
        <input type="text" id="question" name="question" required>

        <label for="answer">Odpowiedź:</label>
        <input type="text" id="answer" name="answer" required>

        <input type="hidden" name="deck_id" value="<?php echo $deckId; ?>">

        <button type="submit">Dodaj Fiszkę</button>
    </form>
    <nav>
    <div class="nav-list">
        <a href=""><li>READING</li></a>
        <a href="../PHP/dashboard.php"><li>FLASHCARDS</li></a>
       <a href="../PHP/quiz.php"><li>QUIZ</li></a>
        <a href="../PHP/stats.php"><li>STATS</li></a>
    </div>
</nav>
    <?php
    $stmtDeck->close();
    $stmtCards->close();
    $conn->close();
    ?>
</body>
</html>
