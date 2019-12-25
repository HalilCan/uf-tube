<?php
require_once("VideoGridItem.php");
require_once("")
class SubscriptionList {

    private $con, $userLoggedInObj;
    private $subList = array();

    public function __construct($con, $userLoggedInObj) {
        $username = $userLoggedInObj->getUsername();

        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;

        $query = $this->con->prepare("SELECT * FROM subscribers WHERE userFrom=:userFrom");
        $query->bindParam(":userFrom", $username);
        $query->execute();
        
        while($targetUsername = $query->fetch(PDO::FETCH_ASSOC)) {
            $userTo = new User($this->con, $targetUsername["userTo"]);
            array_push($this->subList, $userTo);
        }

        return 1;
    }

    public function getUsernames($length) {
        $length = ($length < 1) ? count($this->subList) : $length;
        $usernames = array();

        foreach($this->subList as $user) {
            $username = $user->getUsername();
            array_push($usernames, $username);
        }

        return array_slice($usernames, 0, $length);
    }

    public function getUsers($length) {
        $length = ($length < 1) ? count($this->subList) : $length;
        
        return array_slice($this->subList, 0, $length);
    }

    public function generateSideBarList() {
        $list = "";
        foreach($this->subList as $user) {
            $list .= $this->generateSideBarItem($user);
        }

        return  "<div class='userList-sidebar'>
                    $list
                </div>";
    }

    public function generateSideBarItem($user) {
        $username = $user->getUsername();
        $profileButton = ButtonProvider::createUserProfileButton($this->con, $user);

        return  "<div class='UserItem-sidebar'>
                    <span class='profileButton'>
                        $profileButton
                    </span>
                    <span class='username'>
                        <a href='profile.php?username=$username'>
                            $username
                        </a>
                    </span>
                </div>";
    }

}
?>