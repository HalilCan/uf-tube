<?php
    require_once("includes/header.php");
    require_once("includes/classes/VideoGrid.php");
    $category = "";
    $catId;
    $vidList;

    if(!isset($_GET["category"])) {
            // redirect to homepage if no cat available
            header("Location: index.php");
    } else {
        $catId = $_GET["category"];
    }

    $query = $this->con->prepare("SELECT * FROM categories WHERE id=:id");
    $query->bindParam(":id", $catId);
    $query->execute();

    $catEntry = $query->fetch(PDO::FETCH_ASSOC);
    $category = $catEntry["name"];
    
    $query = $this->con->prepare("SELECT * FROM videos WHERE category=:cat");
    $query->bindParam(":cat", $category);
    $query->execute();
    
    while($videoEntry = $query->fetch(PDO::FETCH_ASSOC)) {
        //gen and add video 
    }

    echo "WELL HELLO, " . $username;
?>

<?php require_once("includes/footer.php");?>