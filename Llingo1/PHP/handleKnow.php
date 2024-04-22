<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit();
}

// Usunięcie aktualnej fiszki z listy
array_pop($_SESSION["cards"]);

// Przekierowanie użytkownika z powrotem do strony quizu
header("Location: quiz.php");
exit();
?>
