<?php

class GridHeader {

    public static function createSubscribedFeedHeader($con, $username) {
        $profileButton = ButtonProvider::createUserProfileButton($con, $username);

        return "<div class='videoGridRowTitle'> 
                    <span class='subFeedUserButton'>
                        $profileButton
                    </span>
                    
                    <span class='subFeedHeaderText'>
                        <a href='profile.php?username=$username'>
                            $username
                        </a>
                    </span>

                    <button type='button' class='subFeedRowHideButton'>
                        X
                    </button>
                </div>";
    }
}