<?php
require_once("VideoGridItem.php");
class DiscoverList {

    private $con, $userLoggedInObj;
    private $discUserList = array();

    public function __construct($con, $userLoggedInObj) {
        $username = $userLoggedInObj->getUsername();
        $uid = $userLoggedInObj->getId();

        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;

        //choose at most 15 random users who are not the current user
        $query = $this->con->prepare("SELECT * FROM users WHERE id!=:uid ORDER BY RAND() LIMIT 15");
        $query->bindParam(":uid", $uid);
        $query->execute();
        
        //get each row in while loop, create new User objs for each username, push objects to discUserList array
        while($someUser = $query->fetch(PDO::FETCH_ASSOC)) {
            $userObj = new User($this->con, $someUser["username"]);
            array_push($this->discUserList, $userObj);
        }

        return 1;
    }

    public function getUsernames($length) {
        $length = ($length < 1) ? count($this->discUserList) : $length;
        $usernames = array();

        foreach($this->discUserList as $user) {
            $username = $user->getUsername();
            array_push($usernames, $username);
        }

        return array_slice($usernames, 0, $length);
    }

    public function getUsers($length) {
        $length = ($length < 1) ? count($this->discUserList) : $length;
        
        return array_slice($this->discUserList, 0, $length);
    }

    public function generateSideBarList() {
        $list = "";
        foreach($this->discUserList as $user) {
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