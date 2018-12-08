<?php 
class VideoUploadData {
    
    private $con;

    public function __construct($con){
        $this->con = $con;
    }

    public function upload($videoUploadData) {

        $targetDir = "uploads/videos/"; //Videos won't be in a table, the paths to the videos will be.
        
    }
}
?>