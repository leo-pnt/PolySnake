<?php
/* script called by the js /!\CLIENT SIDE script at the end of a game to update database of a user */

session_start();
include('config/config.php');


if(isset($_POST['score'])) {
    //for security:
    $_SESSION['score'] = test_input($_POST['score']);
    
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=polysnake', 'root', $mysqlPassword);
    
        $req = $dbh->prepare("SELECT * from user_list WHERE nickname=?");
        $req->execute(array($_SESSION['nickname']));

        $row = $req->fetch();
        
        //update if score is greater:
        if($_SESSION['score'] > $row['best_score'] || is_null($_row['best_score'])) {
            updateBestScore($dbh);
        }

        $dbh = null;
    }
    catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
}

function updateBestScore($dbh) {
    $req = $dbh->prepare('UPDATE user_list SET best_score = ? WHERE nickname = ?');
    $req->execute(array($_SESSION['score'], $_SESSION['nickname']));        
    $dbh = null;
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>