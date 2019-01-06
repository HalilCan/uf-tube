<?php require_once("includes/header.php");

//from subscriptions

    //TODO: Anki list for vocabulary off of 2312
    //TODO: Devil's Index

    //1. get {5} max random subscriptions, create videoGrid rows using [10] max videos for each.
    $subGridSize = 10;
    $maxSubRows = 5;

    $subListObj = new SubscriptionList($con, $userLoggedInObj);
    $subNames = $subListObj->getUsernames($maxSubRows);

    $videoGrid = new VideoGrid($con, $userLoggedInObj);
    
    //TODO: this is missing row divs, create a class.
    echo $videoGrid->generateRowsFromSubNames($subNames, $subGridSize);

//discover

//suggestions

//subscriptions, channel by channel

?>

<?php require_once("includes/footer.php");?>