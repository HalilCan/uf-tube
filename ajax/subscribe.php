<?php

require_once("../includes/config.php");

if(isset($_POST["userTo"]) && isset($_POST["userFrom"])) {
    $userTo = $_POST["userTo"];
    $userFrom = $_POST["userFrom"];

    //check if subscribed
    $query = $con->prepare("SELECT * FROM subscribers WHERE userTo=:userTo AND userFrom=:userFrom");
    $query->bindParam(":userTo", $userTo);
    $query->bindParam(":userFrom", $userFrom);
    $query->execute();

    if($query->rowCount() == 0) {
        //if not, subscribe
        $query = $con->prepare("INSERT INTO subscribers(userTo, userFrom) VALUES(:userTo, :userFrom)");
        $query->bindParam(":userTo", $userTo);
        $query->bindParam(":userFrom", $userFrom);
        $query->execute();
    } else {
        //else, unsubscribe
        $query = $con->prepare("DELETE FROM subscribers WHERE userTo=:userTo AND userFrom=:userFrom");
        $query->bindParam(":userTo", $userTo);
        $query->bindParam(":userFrom", $userFrom);
        $query->execute();
    }

    //finally, return the number of people subscribed to the target user
    $query = $con->prepare("SELECT * FROM subscribers WHERE userTo=:userTo");
    $query->bindParam(":userTo", $userTo);
    $query->execute();

    echo $query->rowCount();
} else {
    echo "One or more of the parameters are not passed correctly into subscribe.php";
}

?>