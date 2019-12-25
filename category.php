<?php
    require_once("includes/header.php");
    require_once("includes/classes/VideoGridItem.php");
    $catId;
    $vidList = "";

    if(!isset($_GET["category"])) {
            // redirect to homepage if no cat available
            header("Location: index.php");
    } else {
        $catId = $_GET["category"];
    }
    
    $query = $con->prepare("SELECT * FROM videos WHERE category=:cat");
    $query->bindParam(":cat", $catId);
    $query->execute();
    
    while($videoEntry = $query->fetch(PDO::FETCH_ASSOC)) {
        //gen and add video box
        $videoItem = new Video($con, $videoEntry, $userLoggedInObj);
        $videoGridItem = new VideoGridItem($videoItem, 0, 50);
        $videoElement = $videoGridItem->create();

        $vidList .= "<div class='videoGridItem'>
                        $videoElement
                    </div>";
    }

    echo "<div class='categoryVideoList'>$vidList</div>";
?>

<?php require_once("includes/footer.php");?>