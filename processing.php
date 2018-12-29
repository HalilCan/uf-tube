<?php 
require_once("includes/header.php");
require_once("includes/classes/VideoUploadData.php");
require_once("includes/classes/VideoProcessor.php");

if(!isSet($_POST["uploadButton"])) { //we 'retrieve' the POSTed data through $_POST, apparently. We'll see.
    echo "No file found for upload!";
    exit();
}

// 1- Create file upload data
$videoUploadData = new VideoUploadData(
                            $_FILES["fileInput"], 
                            $_POST["titleInput"], 
                            $_POST["descriptionInput"], 
                            $_POST["privacyInput"], 
                            $_POST["categoryInput"], 
                            $userLoggedInObj->getUsername());

// 2- Process video data
$videoProcessor = new VideoProcessor($con);
$wasSuccessful = $videoProcessor->upload($videoUploadData);


// 3- Check if upload was successful 
if ($wasSuccessful) {
    echo "Upload successful!";
}

?>
<?php require_once("includes/footer.php");?>