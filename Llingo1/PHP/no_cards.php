<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No Cards</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #070F2B;
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            text-align: center;
            margin-bottom: 50px; /* Dodaj margines na dole, aby uniknąć przysłonięcia przez navbar */
        }

        nav {
            width: 100vw;
            height: 8vh;
            background: #535C91;
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            bottom: 0;
        }

        .nav-list {
            width: 80%;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .nav-list a {
            text-decoration: none;
            color: #fff;
        }

        .nav-list li {
            cursor: pointer;
        }

        .nav-list li:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Powtorzyles Wszytsko</p>
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
