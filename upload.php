<?php 
require_once("includes/header.php");
require_once("includes/classes/VideoDetailsFormProvider.php");
?>

<div class="column">
    <?php  
        $formProvider = new VideoDetailsFormProvider();
        echo $formProvider -> createUploadForm();

        $categoryQuery = $con -> prepare("SELECT * FROM categories");
        $categoryQuery -> execute();

        while($row = $categoryQuery->fetch(PDO::FETCH_ASSOC)) { //using the query we specified, we scroll through the key-value array
            echo $row["name"], "<br>";
        }
    ?>
</div>