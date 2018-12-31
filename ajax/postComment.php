<?php

require_once("../includes/config.php");

if(isset($_POST["commentText"]) && isset($_POST["postedBy"]) && isset($_POST["videoId"])) {
    
} else {
    echo "One or more of the parameters are not passed correctly into postComment.php";
}

?>