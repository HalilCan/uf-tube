<?php 
require_once("includes/header.php");
require_once("includes/classes/VideoDetailsFormProvider.php");
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>

<div class="column">
    <?php  
        $formProvider = new VideoDetailsFormProvider($con);
        echo $formProvider -> createUploadForm();
    ?>
</div>

<?php require_once("includes/footer.php");?>