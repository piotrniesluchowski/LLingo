<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit();
}

// Przeniesienie pierwszej fiszki na koniec listy
$current_card = array_shift($_SESSION["cards"]);
$_SESSION["cards"][] = $current_card;

header("Location: quiz.php");
exit();
?>
