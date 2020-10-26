<?php
session_start();
?>

<html>
    <head>
        <title>Connection</title>
        <meta charset="utf-8" name="viewport"
        content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style/style.css?<?php echo time(); ?>" />
    </head>
    <body>
        
<?php
include('config/config.php');

//check if nickname and id match

if(isset($_POST['nickname'])) $nickname = test_input($_POST['nickname']);
if(isset($_POST['user_id'])) $user_id = test_input($_POST['user_id']);

//connect to database and manage connection/registration
try {
    $dbh = new PDO('mysql:host=localhost;dbname=polysnake', 'root', $mysqlPassword);

    $req = $dbh->prepare("SELECT * from user_list WHERE nickname=?");
    $req->execute(array($nickname));

    $row = $req->fetch();
    if($user_id == $row['user_id'] && !$row['cheater']) {
        //this is a match!

        //setup session:
        $_SESSION['nickname'] = $nickname;
        $_SESSION['user_id'] = $user_id;

        header("Location: game.php");
    }
    elseif($row['cheater']) {
        //this user is a cheater
        ?>
            <h1>Account banned for cheating</h1>
            <p>
                <form action="index.php" method="post">
                    <input class="formButton" type="submit" value="Go back" autofocus>
                </form>
            </p
        <?php
    }
    else {
        //id or nickname incorrect!
        ?>

            <h1>Nickname and ID don't match</h1>
            <p>
                <form action="login.php" method="post">
                    <input type="hidden" name="nickname" value="<?php echo $nickname; ?>">
                    <input class="formButton" type="submit" value="Go back" autofocus>
                </form>
            </p>

        <?php
    }

    $dbh = null;
}
catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

    </body>
</html>