<?php

class VideoGridItem {
    private $video, $largeMode;

    public function __construct($video, $largeMode) {
        $this->video = $video;
        $this->largeMode = $largeMode;
    }

    public function create() {
        $thumbnail = $this->createThumbnail();
        $details = $this->createDetails();        

        $url = "watch.php?id=" . $this->video->getId();

        return "<a href='$url'>
                    <div class='videoGridItem'>
                        $thumbnail
                        $details
                    </div>
                </a>";
    }

    public function createThumbnail() {
        $thumbnail = $this->video->getThumbnail();
        $duration = $this->video->getDuration();

        return "<div class='thumbnail'>
                    <img src='$thumbnail'>
                    <div class='duration'>
                        <span>$duration</span>
                    </div>
                </div>";
    }
    
    public function createDetails() {
        return "";        
    }

}

?>