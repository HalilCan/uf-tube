<?php 
require_once("includes/header.php");

if(!isSet($_POST["uploadButton"])) { //we 'retrieve' the POSTed data through $_POST, apparently. We'll see.
    echo "No file found for upload!";
    exit();
}

// 1- Create file upload data
$videoUploadData = new VideoUploadData(
    $_POST["fileInput"], $_POST["titleInput"], 
    $_POST["descriptionInput"], $_POST["privacyInput"], 
    $_POST["categoryInput"], "Patient Zero");

// 2- Process video data


// 3- Check if upload was successful 


?>
<?php require_once("includes/footer.php");?>