<?php require_once("includes/header.php");

//from subscriptions
    //1. get {5} max random subscriptions, create videoGrid rows using [10] max videos for each.
    $subGridSize = 10;
    
    $videoGrid = new VideoGrid($con, $userLoggedInObj);
    $videos = $videoGrid->generateVideosFromUser($subscribedTo, $subGridSize);
    
    $title = "$subscribedTo's videos"; //create title class for html element
    
    echo $videoGrid->create($videos, null, true);


//discover

//suggestions

//subscriptions, channel by channel

?>

<?php require_once("includes/footer.php");?>