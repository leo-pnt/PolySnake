<html>
    <head>
        <title>Log in</title>
        <meta charset="utf-8" name="viewport"
        content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style/style.css?<?php echo time(); ?>" />
    </head>
    <body>
<?php

//control the form input
if(isset($_POST['nickname'])) $nickname = test_input($_POST['nickname']);
 
//connect to database and manage connection/registration
try {
    //get password from file
    $f = fopen('credo.txt', 'r');
    $mysqlPassword = fgets($f);

    $dbh = new PDO('mysql:host=localhost;dbname=polysnake', 'root', $mysqlPassword);

    fclose($f);    
    
    if(alreadyExist($nickname, $dbh)) {
        ?>
        
        <h1>User registered</h1>
        <p>
            <form action="connect.php" method="post">
                <input type="hidden" name="nickname" value="<?php echo $nickname; ?>">
                <input type="password" name="user_id" placeholder="your id: xxxxxx" required autofocus></p>
                <input class="formButton" type="submit" value="Play">
            </form>
            
            <form action="index.html">
                <input class="formButton" type="submit" value="Go Back">
            </form>
        </p>

        <?php
    }
    else {
        //create user with a unique ID and
        //explain that this ID shouldn't be lost
        $new_user_id = substr(uniqid(), 7, 13);
        

        $req = $dbh->prepare('INSERT INTO user_list(nickname, user_id) VALUES(?, ?)');
        $req->execute(array($nickname, $new_user_id));

        ?>
        
        <p>User created with ID: <strong><?php echo $new_user_id; ?></strong></p>
        <p>Note it for the next connection!</br>Or the account will be lost in the limbo...</p>
        <form action="connect.php" method="post">
            <input type="hidden" name="nickname" value="<?php echo $nickname; ?>">
            <input type="hidden" name="user_id" value="<?php echo $new_user_id; ?>"></p>
            <input class="formButton" type="submit" value="Play">
        </form>
        <?php
    }

    $dbh = null;
}
catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
} 



function alreadyExist($nickname, $dbh) {
    $req = $dbh->prepare("SELECT nickname from user_list WHERE nickname=?");
    $req->execute(array($nickname));
    $result = $req->fetchAll();

    if(!empty($result)) {
            return true;
    }

    return false;
    
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