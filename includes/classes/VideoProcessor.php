<?php 
class VideoProcessor {
    
    private $con;
    private $sizeLimit = 500000000;
    private $allowedTypes = array("mp4", "mkv", "flv", "mov", "wmv");
    private $ffmpegPath;
    private $ffprobePath;

    public function __construct($con){
        $this->con = $con;
        $this->ffmpegPath = realpath("ffmpeg/bin/ffmpeg.exe"); //convert to full path and use .exe for Windows;
        $this->ffprobePath = realpath("ffmpeg/bin/ffprobe.exe"); //convert to full path and use .exe for Windows;
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
                echo "Insert query failed.\n";
                return false;
            }

            if (!$this->convertVideoToMp4($tempFilePath, $finalFilePath)) {
                echo "Upload failed\n";
                return false;
            }

            if (!$this->deleteFile($tempFilePath)) {
                echo "Upload failed at temp file deletion.\n";
                return false;
            }
            
            if (!$this->generateThumbnails($finalFilePath)) {
                echo "Failed to generate thumbnails.\n";
                return false;
            }
        }
        return true;
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

    public function convertVideoToMp4($tempFilePath, $finalFilePath) {
        $cmd = "$this->ffmpegPath -i $tempFilePath $finalFilePath 2>&1"; // we have the final part to see error messages?

        $outputLog = array();

        exec($cmd, $outputLog, $returnCode);

        if($returnCode != 0) {
            //command failed
            foreach($outputLog as $line) {
                echo $line . "<br>";
            }
            return false;
        }

        return true;
    }

    public function deleteFile($filePath){
        if(!unlink($filePath)) {
            echo "Could not delete file \n";
            return false;
        }
        return true;
    }

    public function generateThumbnails($filePath) {
        $thumbnailSize = "210x118";
        $numThumbnails = 3;
        $pathToThumbnail = "uploads/videos/thumbnails";

        $duration = $this->getVideoDuration($filePath);

        $videoId = $this->con->lastInsertId(); // this may be a little dangerous.
        $this->updateDuration($duration, $videoId);
        return true;
    }

    private function getVideoDuration($filePath) {
        return shell_exec("$this->ffprobePath -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 $filePath");
    }

    private function updateDuration($duration, $videoId) {
        $duration = (int)$duration;
        $hours = floor($duration / 3600);
        $minutes = floor(($duration - ($hours * 3600)) / 60);
        $seconds = ($duration % 60);

        $hours = ($hours < 1) ? "" : $hours . ":";
        $minutes = ($minutes < 10) ? "0" . $minutes . ":" : $minutes . ":";
        $seconds = ($seconds < 10) ? "0" . $seconds : $seconds;
        $duration = $hours . $minutes . $seconds;

        $query = $this->con->prepare("UPDATE videos SET duration=:duration WHERE id=:videoId");
        $query->bindParam(":duration", $duration);
        $query->bindParam(":videoId", $videoId);

        $query->execute();
    }
}
?>