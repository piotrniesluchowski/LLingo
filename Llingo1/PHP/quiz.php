<?php
session_start(); // Wznawianie sesji

if (!isset($_SESSION["user_id"])) {
    // Jeśli użytkownik nie jest zalogowany, przekieruj go do strony logowania
    header("Location: index.html");
    exit();
}

// Sprawdzenie czy w sesji istnieją fiszki
if (!isset($_SESSION["cards"]) || empty($_SESSION["cards"])) {
    // Jeśli nie ma żadnych fiszek, przekieruj użytkownika do strony z informacją
    header("Location: no_cards.php");
    exit();
}

// Pobierz aktualną fiszkę
$current_card = end($_SESSION["cards"]);
$question = $current_card["question"];
$answer = $current_card["answer"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
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

        .container {
            text-align: center;
        }

        .card {
            margin-bottom: 20px;
        }

        .buttons {
            margin-top: 20px;
        }

        button {
            background-color: #535C91;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        button:hover {
            background-color: #1B1A55;
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
    <div class="container">
        <div id="card-container">
            <div class='card'><?php echo $question; ?></div>
        </div>
        <div class="buttons">
            <button onclick="handleKnow()">Znam</button>
            <button onclick="handleNotKnow()">Nie znam</button>
        </div>
    </div>

    <script>
        function handleKnow() {
            // Przekieruj do skryptu handle_know.php
            window.location.href = "handleKnow.php";
        }

        function handleNotKnow() {
            // Przekieruj do skryptu handle_not_know.php
            window.location.href = "handleNotKnow.php";
        }
    </script>
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
