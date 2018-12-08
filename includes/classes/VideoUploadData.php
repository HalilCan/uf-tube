<?php 
class VideoUploadData {
    
    private $videoDataArray, $title, $description, $privacy, $category, $uploader; //I don't like this style.

    public function __construct($videoDataArray, $title, $description, $privacy, $category, $uploader) {
        $this->videoDataArray = $videoDataArray;
        $this->title = $title;
        $this->description = $description;
        $this->privacy = $privacy;
        $this->category = $category;
        $this->uploader = $uploader;
    }

    public function getVideoDataArray() {
        return $this->videoDataArray;
    }
    public function getTitle() {
        return $this->title;
    }
    public function getDescription() {
        return $this->description;
    }
    public function getPrivacy() {
        return $this->privacy;
    }
    public function getCategory() {
        return $this->category;
    }
    public function getUploader() {
        return $this->uploader;
    }
}
?>