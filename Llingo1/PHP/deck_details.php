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
            background-color: #141E46;
            color: #FFF5E0;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column-reverse;
            justify-content: start;
            align-items: center;
            height: 100vh;
            width: 100vw;
        }

        h3 {
            color: #FFF5E0;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: start;
            width: 100vw;
            height: 100vh;
            margin: 80px;
        }

        .card {
            display: flex;
            height: 100px;
            background-color: #1B1A55;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 15px;
            text-align: center;
            color: #FFF5E0;
            width: 200px;
        }

        form {
            display: flex;
            flex-direction: column;
            text-align: center;
            height: fit-content;
        }

        input {
            padding: 10px;
        }

        button {
            background-color: #41B06E;
            color: #FFF5E0;
            padding: 10px 15px;
            margin-top: 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #8DECB4;
            box-shadow: 0 0 10px #8DECB4;
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
            height: 20px
            margin-bottom: 20px;
            margin-right: 20px; 
}

.delete-button-right {
    position: absolute;
    top: 5px;
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
            background: #41B06E;
            position: fixed;
            flex-direction: row;
            bottom: 0;
            list-style-type: none;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
        }
        .nav-list{
            width: 80%;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            color:#FFF5E0;
        }
        .nav-list a{
            color:#FFF5E0;
        }
        .nav-list li:hover{
            color:#FFF5E0
            text-decoration: none;
        }
        .wrapper{
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: row;

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
            echo "<button class='delete-button-right' onclick='deleteCard($deckId, {$rowCards["card_id"]})'>X</button>";
            echo "<strong>Pytanie:</strong> " . $rowCards["question"] . "<br>";
            echo "<strong>Odpowiedź:</strong> " . $rowCards["answer"];
            echo "</div>";
        }
        ?>
            <form action="add_card.php" method="post">
        <label for="question">Pytanie:</label>
        <input type="text" id="question" name="question" required>

        <label for="answer">Odpowiedź:</label>
        <input type="text" id="answer" name="answer" required>

        <input type="hidden" name="deck_id" value="<?php echo $deckId; ?>">

        <button type="submit">Dodaj Fiszkę</button>
    </form>
    </div>
    <nav>
    <div class="nav-list">
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
