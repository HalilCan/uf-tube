<?php 

require_once("includes/classes/VideoInfoControls.php");

class VideoInfoSection {
    private $con, $video, $userLoggedInObj;

    public function __construct($con, $video, $userLoggedInObj) {
        $this->con = $con;
        $this->video = $video;
        $this->userLoggedInObj = $userLoggedInObj;
        $this->maxDescLen = 50;
    }

    public function create() {
        return $this->createPrimaryInfo() . $this->createSecondaryInfo(0);
    }

    private function createPrimaryInfo() {
        $title = $this->video->getTitle();
        $views = $this->video->getViews();

        $videoInfoControls = new VideoInfoControls($this->video, $this->userLoggedInObj);
        $controls = $videoInfoControls->create();

        return "<div class='videoInfo'>
                    <h1>$title</h1>
                    <div class='bottomSection'>
                        <span class='viewCount'>$views views</span>
                        $controls
                    </div>
                </div>";
    }

    private function createSecondaryInfo($isFullDesc) {
        if ($isFullDesc) {
            $description = $this->video->getDescription();
            $fullDescription = $description;
        } else {
            $description = $this->video->getAbbrevDescription($this->maxDescLen);
            $fullDescription = $this->video->getDescription();
        }
        $ellipsis = (strlen($description) < strlen($fullDescription)) ? "..." : ""; 

        $uploadDate = $this->video->getUploadDate();
        $uploadedBy = $this->video->getUploadedBy();
        $profileButton = ButtonProvider::createUserProfileButton($this->con, $uploadedBy);

        if($uploadedBy == $this->userLoggedInObj->getUsername()) {
            $actionButton = ButtonProvider::createEditVideoButton($this->video->getId());
        } else {
            $userToObject = new User($this->con, $uploadedBy);
            $actionButton = ButtonProvider::createSubscriberButton($this->con, $userToObject, $this->userLoggedInObj);
        }

        return "<div class='secondaryInfo'>
                    <div class='topRow'>
                        $profileButton
                        <div class='uploadInfo'>
                            <span class='owner'>
                                <a href='profile.php?username=$uploadedBy'>
                                    $uploadedBy
                                </a>
                            </span>
                            <span class='date'>
                                Published on $uploadDate
                            </span>
                        </div>
                        $actionButton
                    </div>
                    <div class='descriptionContainer'>
                        <p class='videoDescription'> " . $description . $ellipsis . " </p>
                        <p class = 'hiddenDescription videoDescription')'> $fullDescription </p>
                    </div>
                </div>";
    }

    public function expandDescription() {
        $description = $this->video->getDescription();
        $description = substr($description, $this->maxDescLen);
        echo $description;
    }
}

?>