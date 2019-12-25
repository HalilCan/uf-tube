<?php 
    require_once("includes/header.php");
    require_once("includes/classes/VideoGridItem.php");
    $username = "";
    $vidList = "";

    if(!isset($_GET["username"])) {
        // handle /profile.php?username=username vs /profile.php
        if (isset($_SESSION["userLoggedIn"])) {
            $username = $_SESSION["userLoggedIn"];
            header("Location: profile.php?username=" . $username);
        } else {
            // redirect to homepage if no profile available
            header("Location: index.php");
        }
    } else {
        $username = $_GET["username"];
    }
    $user = new User($con, $username);

    $query = $con->prepare("SELECT * FROM videos WHERE uploadedBy=:un");
    $query->bindParam(":un", $username);
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