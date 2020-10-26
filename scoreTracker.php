<?php
session_start();
include('config/config.php');

if(isset($_POST['score_tracked'])) {
    $incomingScore = test_input($_POST['score_tracked']);
    $lastKnownScore = $_SESSION['score_tracked'];

    if($incomingScore - $lastKnownScore > 1) {
        //cheating handling:
        $dbh = new PDO('mysql:host=localhost;dbname=polysnake', 'root', $mysqlPassword);
    
        $req = $dbh->prepare("UPDATE user_list SET cheater=?, best_score=? WHERE nickname=?");
        $req->execute(array(1, null, $_SESSION['nickname']));

        $dbh = null;
    }
    else {
        //update normal playing:
        $_SESSION['score_tracked'] = $incomingScore;
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>