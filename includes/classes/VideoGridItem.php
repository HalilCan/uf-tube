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

    public function createVertical() {
        $thumbnail = $this->createThumbnail();
        $details = $this->createVerticalDetails();        

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
        $title = $this->video->getTitle();
        $views = $this->video->getViews();

        $uploadDate = $this->video->getUploadDate();
        $uploadedBy = $this->video->getUploadedBy();
        

        return "<div class='videoDetails'>
                    <h1>$title</h1>
                    <div class='bottomSection'>
                        <div class='uploadInfo'>
                            <span class='owner'>
                                <a href='profile.php?username=$uploadedBy'>
                                    $uploadedBy
                                </a>
                            </span>
                            <span class='date'>
                                $uploadDate
                            </span>
                            <span class='viewCount'>$views views</span>
                        </div>
                    </div>
                </div>";       
    }

    public function createVerticalDetails() {
        $title = $this->video->getTitle();
        $views = $this->video->getViews();

        $uploadDate = $this->video->getUploadDate();
        $uploadedBy = $this->video->getUploadedBy();
        

        return "<div class='videoDetails'>
                    <h1>$title</h1>
                    <div class='bottomSection'>
                        <div class='uploadInfo'>
                            <span class='firstRow'>
                                <span class='owner'>
                                    <a href='profile.php?username=$uploadedBy'>
                                        $uploadedBy
                                    </a>
                                </span>
                                <span class='date'>
                                    $uploadDate
                                </span>
                            </span>
                            <span class='viewCount'>$views views</span>
                        </div>
                    </div>
                </div>";       
    }



}

?>