<?php
require_once("VideoGridItem.php");
class SubscriptionList {

    private $con, $userLoggedInObj, $subList;

    public function __construct($con, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;

        $query = $this->con->prepare("SELECT * FROM subscriptions WHERE userFrom=:userFrom");
        $query->bindParam(":userFrom", $userLoggedInObj->getUsername());
        $query->execute();

        $usersTo = array();
        
        while($targetUsername = $query->fetch(PDO::FETCH_ASSOC)) {
            $userTo = new User($this->con, $targetUsername);
            array_push($usersTo, $userTo);
        }

        return 1;
    }

    public function getUsernames() {
        $usernames = array();

        foreach($this->subList as $user) {
            array_push($usernames, $user->getUsername());
        }

        return $usernames;
    }

    public function generateSideBarList() {

    }

    public function generateSideBarItem($user) {
        $username = $user->getUsername();
        $profileButton = ButtonProvider::createUserProfileButton($this->con, $user);

        return  "<div class='UserItem-Sidebar'>
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