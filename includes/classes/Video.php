<?php 
class Video {

    private $con, $input, $userLoggedInObj;

    public function __construct($con, $input, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;

        if(is_array($input)) {
            $this->sqlData = $input;
        } else {
            $query = $this->con->prepare("SELECT * FROM videos WHERE id=:id");
            $query->bindParam(":id", $input);
            $query->execute();

            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        }

    }

    public function getId() {
        return $this->sqlData["id"];
    }

    public function getUploadedBy() {
        return $this->sqlData["uploadedBy"];
    }

    public function getTitle() {
        return $this->sqlData["title"];
    }

    public function getDescription() {
        return $this->sqlData["description"];
    }
 
    public function getPrivacy() {
        return $this->sqlData["privacy"];
    }
    
    public function getFilePath() {
        return $this->sqlData["filePath"];
    }
 
    public function getCategory() {
        return $this->sqlData["category"];
    } 

    public function getUploadDate() {
        return $this->sqlData["uploadDate"];
    } 
 
    public function getViews() {
        return $this->sqlData["views"];
    }

    public function getLikes() {
        $query = $this->con->prepare("SELECT count(*) as 'count' FROM likes WHERE videoID=:videoId");
        $query->bindParam(":videoId", $videoId);
        $videoId = $this->getId();
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data["count"];
    }

    public function getDisikes() {
        $query = $this->con->prepare("SELECT count(*) as 'count' FROM dislikes WHERE videoID=:videoId");
        $query->bindParam(":videoId", $videoId);
        $videoId = $this->getId();
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data["count"];
    }

    public function getDuration() {
        return $this->sqlData["duration"];
    }

    public function incrementViews() {
        $query = $this->con->prepare("UPDATE videos SET views=views+1 WHERE id=:id");
        $query->bindParam(":id", $videoId);

        $videoId = $this->getId(); //video ID bound for the query in the previous statement can be set later like this.
        $query->execute();

        $this->sqlData["views"] = $this->sqlData["views"] + 1;
    }
}


?>