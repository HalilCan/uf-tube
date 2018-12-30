<?php 
require_once("config.php"); 
require_once("includes/classes/User.php"); 
require_once("includes/classes/Video.php"); 

$usernameLoggedIn = User::isLoggedIn() ? $_SESSION["userLoggedIn"] : "" ;
$userLoggedInObj = new User($con, $usernameLoggedIn);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>untuckTube</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="assets/stylesheets/main.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script src="assets/scripts/main.js"></script>
    <script src="assets/scripts/commonActions.js"></script>
    <script src="assets/scripts/userActions.js"></script>

</head>
<body>
    <div id="pageContainer">

        <div id="mastHeadContainer">            
            <button class="navShowHide">
                <img src="assets/images/icons/menu.png" title="Sidebar button" alt="Sidebar button">
            </button>

            <a class="logoContainer" href="index.php">
                <img src="assets/images/icons/unfuckTubeLogo.png" title="logo" alt="Site logo">
            </a>

            <div class="searchBarContainer">
                <form action="search.php" method="GET">
                    <input type="text" class="searchBar" name="term" placeholder="Search">
                    <button class="searchButton">
                        <img src="assets/images/icons/search.png" title="search" alt="Search button">
                    </button>
                </form>
            </div>

            <div class="rightIcons">
                <a href="upload.php">
                    <img class="upload" src="assets/images/icons/upload.png">
                </a>
                <a href="signIn.php">
                    <img class="upload" src="assets/images/profilePictures/default.png">
                </a>
            </div>
        </div>

        <div id="sideNavContainer" style="display: none;">
            sideNav
        </div>

        <div id="mainSectionContainer">
            <div id="mainContentContainer">