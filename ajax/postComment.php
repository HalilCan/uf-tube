<?php

require_once("../includes/config.php");
require_once("../includes/classes/User.php");
require_once("../includes/classes/Comment.php");

if(isset($_POST["commentText"]) && isset($_POST["postedBy"]) && isset($_POST["videoId"])) {
    $userLoggedInObj = new User($con, $_SESSION["userLoggedIn"]);

    $query = $con->prepare("INSERT INTO comments(postedBy, videoId, responseTo, body)
                            VALUES(:postedBy, :videoId, :responseTo, :body)");
    $query->bindParam(":postedBy", $postedBy);
    $query->bindParam(":videoId", $videoId);
    $query->bindParam(":responseTo", $responseTo);
    $query->bindParam(":body", $commentText);

    $commentText = $_POST["commentText"];
    $postedBy = $_POST["postedBy"];
    $videoId = $_POST["videoId"];
    $responseTo = isset($_POST["responseTo"]) ? $_POST["responseTo"] : 0;

    $query->execute();

    //lastInsertId 'resets' if you make anohter query, e.g. userLoggedInObj
    $newComment = new Comment($con, $con->lastInsertId(), $userLoggedInObj, $videoId);
    echo $newComment->create();
} else {
    echo "One or more of the parameters are not passed correctly into postComment.php";
}

?>