<?php 

require_once("includes/classes/ButtonProvider.php");

class VideoInfoControls {
    private $video, $userLoggedInObj;

    public function __construct($video, $userLoggedInObj) {
        $this->video = $video;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create() {
        $likeButton = $this->createLikeButton();
        $dislikeButton = $this->createDislikeButton();


        return "<div class='controls'>
                    $likeButton
                    $dislikeButton
                </div>";
    }

    private function createLikeButton() {
        $text = $this->video->getLikes();
        $videoId = $this->video->getId();
        $action = "likeVideo(this, $videoId)";
        $class = "likeButton";

        $imageSrc = "assets/images/icons/thumb-up.png";

        //todo: change button if video has been liked already, same for dislike

        return ButtonProvider::createButton($text, $imageSrc, $action, $class);
    }
    
    private function createDislikeButton() {
        return ButtonProvider::createButton("Dislike", "", "", ""); 
    }
}

?>