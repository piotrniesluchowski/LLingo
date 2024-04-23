<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Quiz</title>
    <style>
body {
    color: #fff;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

select, button {
    padding: 15px 20px; 
    font-size: 16px;
    margin: 10px;
    border: none;
    border-radius: 5px;
    background-color: #41B06E;
    color: #FFF5E0;
    cursor: pointer;
    transition: background-color 0.3s; 
}

select:hover, button:hover {
    background-color: #367855;
}

h3 {
    font-size: 24px; 
}

li {
    list-style-type: none;
    text-align: left;
}

ul {
    padding: 0;
}


    </style>
</head>
<body>
<nav>
        <ul class="nav-list">
            <li><a href="../PHP/dashboard.php">FLASHCARDS</a></li>
            <li><a href="../PHP/quiz.php">QUIZ</a></li>
            <li><a href="../PHP/stats.php">STATS</a></li>
        </ul>
    </nav>

    <div>
    <?php
session_start();

// Dane dostępowe do bazy danych
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "llingo";

// Utwórz połączenie z bazą danych
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

// Sprawdź połączenie
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sprawdź, czy użytkownik jest zalogowany
if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit();
}

// Pobierz ID użytkownika
$userId = $_SESSION["user_id"];

// Sprawdź, czy formularz został przesłany
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["deck_id"])) {
        // Pobierz identyfikator wybranego decku z formularza
        $selected_deck_id = $_POST["deck_id"];

        // Pobierz pytania z wybranego decku
        $sql_questions = "SELECT * FROM cards WHERE deck_id = ?";
        $stmt_questions = $conn->prepare($sql_questions);
        $stmt_questions->bind_param("i", $selected_deck_id);
        $stmt_questions->execute();
        $result_questions = $stmt_questions->get_result();

        // Przechowaj pytania w tablicy sesji
        $_SESSION['questions'] = [];

        // Wyświetl pytania
        if ($result_questions->num_rows > 0) {
            while ($row_question = $result_questions->fetch_assoc()) {
                $_SESSION['questions'][] = $row_question;
            }
            $_SESSION['current_question_index'] = 0; // Ustaw indeks aktualnego pytania na początku
            displayQuestion($_SESSION['questions'][0]);
        } else {
            echo "<p>Brak pytań w wybranym decku.</p>";
        }

        // Zamknij połączenie z bazą danych
        $stmt_questions->close();
    } elseif (isset($_POST['next_question'])) {
        // Wyświetl kolejne pytanie po kliknięciu przycisku "Następne pytanie"
        $currentIndex = ++$_SESSION['current_question_index'];
        if ($currentIndex < count($_SESSION['questions'])) {
            displayQuestion($_SESSION['questions'][$currentIndex]);
        } else {
            echo "<p>Brak kolejnych pytań.</p>";
        }
    } elseif (isset($_POST['show_answer'])) {
        // Wyświetl odpowiedź na bieżące pytanie po kliknięciu przycisku "Pokaż odpowiedź"
        $currentIndex = $_SESSION['current_question_index'];
        if (isset($_SESSION['questions'][$currentIndex])) {
            $currentQuestion = $_SESSION['questions'][$currentIndex];
            echo "<p>Odpowiedź: " . $currentQuestion['answer'] . "</p>";
            // Wyświetl przycisk "Następne pytanie"
            echo "<form method='post' action=''>";
            echo "<button type='submit' name='next_question'>Następne pytanie</button>";
            echo "</form>";
        } else {
            echo "<p>Błąd: Brak pytania.</p>";
        }
    }
} else {
    // Wyświetl formularz wyboru decku
    echo "<form method='post' action=''>";
    echo "<select name='deck_id'>";
    // Pobierz dostępne decki użytkownika
    $sql_decks = "SELECT * FROM decks WHERE user_id = $userId";
    $result_decks = $conn->query($sql_decks);
    if ($result_decks->num_rows > 0) {
        while ($row_deck = $result_decks->fetch_assoc()) {
            echo "<option value='" . $row_deck['deck_id'] . "'>" . $row_deck['deck_name'] . "</option>";
        }
    } else {
        echo "<option value=''>Brak dostępnych talii</option>";
    }
    echo "</select>";
    echo "<button type='submit'>Rozpocznij Quiz</button>";
    echo "</form>";
}

// Zamknij połączenie z bazą danych
$conn->close();

// Funkcja do wyświetlania pytania
function displayQuestion($question) {
    echo "<form method='post' action=''>";
    echo "<div>";
    echo "<h3>Pytanie:</h3>";
    echo "<p>" . $question['question'] . "</p>";
    echo "</div>";
    // Dodaj przycisk "Pokaż odpowiedź"
    echo "<button type='submit' name='show_answer'>Pokaż odpowiedź</button>";
    echo "</form>";
}
?>




    </div>
</body>
</html>
