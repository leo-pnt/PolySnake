<html>
    <head>
        <title>Home</title>
        <meta charset="utf-8" name="viewport"
        content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style/style.css?<?php echo time(); ?>" />
    </head>
    <body>
        <div class="center-v-h">

            <h1 id="logo">🐍</h1>
            <h1>PolySnake<sub>0.1.1</sub></h1>
            <h3>web-based snake game</h3>

            <form action="login.php" method="post">
                <input class="formText" type="text" name="nickname"
                placeholder="nickname" required autofocus>
                <input class="formButton" type="submit" value="Log in">
            </form>

<table>
    <caption>Leaderboard</caption>
    <tr>
        <th>Nickname</th>
        <th>Score</th>
    </tr>
<?php
include('config/config.php');

$dbh = new PDO('mysql:host=localhost;dbname=polysnake', 'root', $mysqlPassword);

$req = $dbh->query("SELECT nickname, best_score from user_list ORDER BY best_score DESC LIMIT 0,3");

while ($data = $req->fetch())
{
    echo '<tr>';
    echo '<td>' . htmlspecialchars($data['nickname']) . '</td>';
    echo '<td>' . htmlspecialchars($data['best_score']) . '</td>';
    echo '</tr>';
}

$req->closeCursor();
$dbh = null;

?>
</table>

        </div>
    </body>
</html>