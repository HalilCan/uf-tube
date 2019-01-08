<?php

class GridHeader {

    public static function createSubscribedFeedHeader($con, $username) {
        $profileButton = ButtonProvider::createUserProfileButton($con, $username);

        return "<div class='videoGridRowTitle'> 
                    <span class='subFeedUserButton'>
                        $profileButton
                    </span>
                    <a class='subFeedHeaderText' href='profile.php?username=$username'>
                        $username
                    </a>
                    <button class='subFeedRowHideButton'>
                        X
                    </button>
                    <span class='subFeed'
                </div>";
    }
}