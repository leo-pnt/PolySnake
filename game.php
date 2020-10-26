<?php
session_start();

include('config/config.php');

$dbh = new PDO('mysql:host=localhost;dbname=polysnake', 'root', $mysqlPassword);

$req = $dbh->prepare("SELECT * from user_list WHERE nickname=?");
$req->execute(array($_SESSION['nickname']));

$row = $req->fetch();
$bestScore = $row['best_score']; 

?>

<!DOCTYPE html>
<html>
    <head>
        <title>PolySnake</title>
        <meta charset="utf-8" name="viewport"
        content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" type="text/css" href="style/game.css?<?php echo time(); ?>" />

        <script src="lib/jquery-3.5.1.min.js"></script>
        <script src="lib/hammer.min.js"></script>
        <script src="lib/p5.min.js"></script>
    </head>

    <body>
        <p id="gametext"style="font-family: 'Courier New', Courier, monospace;"></p>
        <p id="score">score: 0</p>
        <pre id="scoreBest">        best: <?php echo $bestScore; ?></pre>

        <!--the div used by the game script to display it:-->
        <div id="gameBoard"></div>
    </body>
   
    <!--load classes-->
    <script src="src/grid.js"></script>
    <script src="src/snake.js"></script>
    <script src="src/apple.js"></script>

    <!--load main-->
    <script src="src/main.js"></script>
</html>