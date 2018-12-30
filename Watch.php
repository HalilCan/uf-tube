<?php 

require_once("includes/header.php");
require_once("includes/classes/VideoPlayer.php");
require_once("includes/classes/VideoInfoSection.php");

if(!isset($_GET["id"])) {
    echo "No url passed into page";
    exit();
}

$video = new Video($con, $_GET["id"], $userLoggedInObj);
$video->incrementViews();
?>

<div class = "watchLeftColumn">

<?php
    $videoPlayer = new VideoPlayer($video);
    echo $videoPlayer->create(true);
    
    $videoInfoSection = new VideoInfoSection($con, $video, $userLoggedInObj);
    echo $videoInfoSection->create();
?>

</div>
<div class = "watchRightColumn">

</div>


<?php require_once("includes/footer.php");?>