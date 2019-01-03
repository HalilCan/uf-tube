<?php require_once("includes/header.php");

//from subscriptions
    //1. get {5} max random subscriptions, create videoGrid rows using [10] max videos for each.
    $subGridSize = 10;
    $videoGrid = new VideoGrid($con, $userLoggedInObj);
    $videos = $videoGrid->generateVideosFromUser($subscribedTo, $subGridSIze);
    $title = //
    echo $videoGrid->create($videos, null, true);


//discover

//suggestions

//subscriptions, channel by channel

?>

<?php require_once("includes/footer.php");?>