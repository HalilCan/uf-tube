<?php
require_once("VideoGridItem.php");
class VideoGrid {

    private $con, $userLoggedInObj;
    private $largeMode = false;
    private $gridClass = "videoGrid";

    public function __construct($con, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create($videos, $title, $showFilter) {

        if($videos == null) {
            $gridItems = $this->generateItems();
        }
        else {
            $gridItems = $this->generateItemsFromVideos($videos);
        }

        $header = "";

        if($title != null) {
            $header = $this->createGridHeader($title, $showFilter);
        }

        return "$header
                <div class='$this->gridClass'>
                    $gridItems
                </div>";
    }
    
    public function generateItems() {
        $query = $this->con->prepare("SELECT * FROM videos ORDER BY RAND() LIMIT 15");
        $query->execute();
        
        $elementsHtml = "";
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $video = new Video($this->con, $row, $this->userLoggedInObj);
            $item = new VideoGridItem($video, $this->largeMode);
            $elementsHtml .= $item->create();
        }
        return $elementsHtml;
    }

    public function generateItemsFromVideos($videos) {
        $elementsHtml = "";
        foreach($videos as $video) {
            $item = new VideoGridItem($video, $this->largeMode);
            $elementsHtml .= $item->create();
        }
        return $elementsHtml;
    }

    public function generateVideosFromUser($user, $maxNum) {
        $query = $this->con->prepare("SELECT * FROM videos WHERE uploadedBy=:uploadedBy ORDER BY RAND() LIMIT $maxNum");
        $query->bindParam(':uploadedBy', $user);
        $query->execute();

        $videos = array();
        
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $video = new Video($this->con, $row, $this->userLoggedInObj);
            array_push($videos, $video);
        }

        return $videos;
    }
    
    public function createGridHeader($title, $showFilter) {
        return "<div class='videoGridRowTitle'>
                    $title
                </div>"; //TODO: make this an actual thing lmao

    }

    public function generateRowsFromSubNames($subNames, $gridSize, $header) {
        $grid = "";

        foreach($subNames as $subscribedTo) {
            $row = "";
            
            $videos = $this->generateVideosFromUser($subscribedTo, $gridSize);
            
            $title = "$subscribedTo's videos"; //TODO: create title class for html element
            
            $header =   "<div class='videoGridRowTitle'>
                            $title
                        </div>";

            $row .= $this->create($videos, $header, true);
            
            $rowContainer = "<div class='videoGridRowContainer'>
                              $row
                            </div>";
            $grid .= $rowContainer;
        }

        $gridContainer = "<div class='videoGridContainer'>
                            $grid
                        </div>";

        return $gridContainer;
    }

}
?>