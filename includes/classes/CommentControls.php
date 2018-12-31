<?php 

require_once("ButtonProvider.php");

class CommentControls {
    private $con, $comment, $userLoggedInObj;

    public function __construct($con, $comment, $userLoggedInObj) {
        $this->con = $con;
        $this->comment = $comment;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create() {
        $replyButton = $this->createReplyButton();
        $likeButton = $this->createLikeButton();
        $likesCount = $this->createLikesCount();
        $dislikeButton = $this->createDislikeButton();
        $dislikesCount = $this->createDislikesCount();
        $replySection = $this->createReplySection();


        return "<div class='controls'>
                    $replyButton
                    $likeButton
                    $likesCount
                    $dislikeButton
                    $dislikesCount
                    $replySection
                </div>";
    }

    private function createReplyButton() {
        $text = "REPLY";
        $action = "toggleReply(this)";
        
        return ButtonProvider::createButton($text, null, $action, null);
    }

    private function createLikesCount() {
        $text = $this->comment->getLikes();
        if ($text == 0) $text = "";
        return "<span class='likesCount'>$text</span>";
    }

    private function createLikeButton() {
        $commentId = $this->comment->getId();
        $videoId = $this->comment->getVideoId();
        $action = "likeComment($commentId, this, $videoId)";
        $class = "likeButton";

        $imageSrc = "assets/images/icons/thumb-up.png";

        if($this->comment->wasLikedBy()) {
            $imageSrc = "assets/images/icons/thumb-up-active.png";
        }

        return ButtonProvider::createButton("", $imageSrc, $action, $class);
    }
    
    private function createDislikeButton() {
        $commentId = $this->comment->getId();
        $videoId = $this->comment->getVideoId();
        $action = "dislikeComment($commentId, this, $videoId)";
        $class = "dislikeButton";

        $imageSrc = "assets/images/icons/thumb-down.png";

        if($this->comment->wasDislikedBy()) {
            $imageSrc = "assets/images/icons/thumb-down-active.png";
        }
        return ButtonProvider::createButton("", $imageSrc, $action, $class);
    }
}

?>