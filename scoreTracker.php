<?php
session_start();

if(isset($_POST['score_tracked'])) {
    $incomingScore = test_input($_POST['score_tracked']);
    $lastKnownScore = $_SESSION['score_tracked'];

    if($incomingScore - $lastKnownScore > 1) {
        echo "cheater!";
        //put code to handle cheaters
    }
    else {
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