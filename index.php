<?php require_once("includes/header.php");

//from subscriptions

    //TODO: Anki list for vocabulary off of 2312
    //TODO: Devil's Index

    //1. get {5} max random subscriptions, create videoGrid rows using [10] max videos for each.
    $subGridSize = 10;
    $maxSubRows = 5;
    $maxThumbnailTextLen = 20;

    if (isset($_SESSION["userLoggedIn"])) {
        $subListObj = new SubscriptionList($con, $userLoggedInObj);
        $subNames = $subListObj->getUsernames($maxSubRows);
    
        $videoGrid = new VideoGrid($con, $userLoggedInObj, $maxThumbnailTextLen);
        
        //TODO: this is missing row divs, create a class.
        echo $videoGrid->generateRowsFromSubNames($subNames, $subGridSize, null);
    }

//discover

    $discoverListObj = new DiscoverList($con, $userLoggedInObj);
    $discSubNames = $discoverListObj->getUsernames($maxSubRows);
    
    $videoGrid = new VideoGrid($con, $userLoggedInObj, $maxThumbnailTextLen);

    //TODO: this is missing row divs, create a class. (2019: apparently)
    echo $videoGrid->generateRowsFromSubNames($discSubNames, $subGridSize, null);
    
//suggestions

//subscriptions, channel by channel

?>

<?php require_once("includes/footer.php");?>