<?php 
class VideoProcessor {
    
    private $con;
    private $sizeLimit = 500000000;
    private $allowedTypes = array("mp4", "mkv", "flv", "mov", "wmv");

    public function __construct($con){
        $this->con = $con;
    }

    public function upload($videoUploadData) {

        $targetDir = "uploads/videos/"; //Videos won't be in a table, the paths to the videos will be.
        $videoData = $videoUploadData->getVideoDataArray();

        $tempFilePath = $targetDir . uniqid() . basename($videoData["name"]); //uniqid is a core php function, it's automatically generated
        $tempFilePath = str_replace(" ", "_", $tempFilePath);

        $isValidData = $this->processData($videoData, $tempFilePath);
        
        if (!$isValidData) {
            return false;
        }

        if (move_uploaded_file($videoData["tmp_name"], $tempFilePath)) { //if the file path is valid, the file will be moved
            
            $finalFilePath = $targetDir . uniqid() . ".mp4";

            if(!$this->insertVideoData($videoUploadData, $finalFilePath)) {
                echo "Insert query failed.";
                return false;
            }


        }


    }

    private function processData($videoData, $filePath) {
        $videoType = pathInfo($filePath, PATHINFO_EXTENSION);

        if (!$this->isValidSize($videoData)) {
            echo "File too large, can't be larger than " . $this->sizeLimit . " bytes.";
            return false;
        } else if (!$this->isValidType($videoType)) {
            echo "Invalid file type.";
            return false;
        } else if ($this->hasError($videoData)) {
            echo "Error code: " . $videoData["error"];
            return false;
        }
        return true; //Overlooking adding this has caused me almost two hours.
    }

    private function isValidSize($data) {
        return $data["size"] <= $this->sizeLimit;
    }
    
    private function isValidType($type) {
        $lowercased = strtolower($type);
        return in_array($lowercased, $this->allowedTypes);
    }
    
    private function hasError($data) {
        return $data["error"] != 0;
    }

    private function insertVideoData($uploadData, $filePath) {
        $query = $this->con->prepare("INSERT INTO videos(title, uploadedBy, description, privacy, category, filePath)
                                    VALUES(:title, :uploadedBy, :description, :privacy, :category, :filePath)"); //needs to match the row names, clearly.
        
        $title = $uploadData->getTitle();
        $uploadedBy = $uploadData->getUploader();
        $description = $uploadData->getDescription();
        $privacy = $uploadData->getPrivacy();
        $category = $uploadData->getCategory();

        $query->bindParam(":title", $title);
        $query->bindParam(":uploadedBy", $uploadedBy);
        $query->bindParam(":description", $description);
        $query->bindParam(":privacy", $privacy);
        $query->bindParam(":category", $category);
        $query->bindParam(":filePath", $filePath);

        return $query->execute();
    }
}
?>