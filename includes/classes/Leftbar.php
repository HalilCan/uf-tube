<?php
require_once("VideoGridItem.php");
class Leftbar {

    private $con, $userLoggedInObj;
    private $subList = array(), $catList = array();
    public $content;

    public function __construct($con, $userLoggedInObj) {
        $username = $userLoggedInObj->getUsername();

        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;

        $query = $this->con->prepare("SELECT * FROM subscribers WHERE userFrom=:userFrom");
        $query->bindParam(":userFrom", $username);
        $query->execute();
        
        while($subEntry = $query->fetch(PDO::FETCH_ASSOC)) {
            $userTo = new User($this->con, $subEntry["userTo"]);
            array_push($this->subList, $userTo);
        }

        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute();
        
        while($category = $query->fetch(PDO::FETCH_ASSOC)) {
            array_push($this->catList, $category["name"]);
        }

        $this->content = $this->generateSideBarList();
        return 0;
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
        $subElemList = "";
        $someSub = 0;
        foreach($this->subList as $user) {
            $subElemList .= $this->generateSideBarItem($user);
            $someSub = 1;
        }

        if ($someSub == 0) {
            $subElemList = "You don't have any subscriptions!";    
        }

        $catElemList = "";
        foreach($this->catList as $category) {
            $catElemList .= $this->generateCategoryItem($category);
        }

        return  "<div class='userList-sidebar'>
                    <div class='categoryListContainer'>
                        <div class='categoryListHeader'>
                            Categories
                        </div>
                        <div class='categoryList'>
                            $catElemList
                        </div>
                    </div>
                    <div class='subListContainer'>
                        <div class='subscriptionListHeader'>
                            Subscriptions
                        </div>
                        <div class='subscriptionList'>
                            $subElemList
                        </div>
                    </div>
                </div>";
    }

    public function generateSideBarItem($user) {
        $username = $user->getUsername();
        $profileButton = ButtonProvider::createUserProfileButton($this->con, $username);

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

    public function generateCategoryItem($category) {
        return  "<div class='categoryItem-sidebar'>
                    <span class='categoryButton'>
                        <a href='category.php?category=$category'>
                            $category
                        </a>
                    </span>
                </div>";
    }

}
?>