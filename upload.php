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

<script>
$("form").submit(() => {
    $("#loadingModal").modal("show");
});
</script>

<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      
      <div class="modal-body">
        Please wait, upload processing...
        <img src="assets/images/icons/loading-spinner.gif">
      </div>
      
    </div>
  </div>
</div>

<?php require_once("includes/footer.php");?>