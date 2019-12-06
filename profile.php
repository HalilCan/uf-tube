<?php require_once("includes/header.php");

$username = "";

if(!isset($_GET["username"])) {
    // handle /profile.php?username=username vs /profile.php
    if (isset($_SESSION["userLoggedIn"])) {
        $username = $_SESSION["userLoggedIn"];
        header("Location: profile.php?username=" . $username);
    } else {
        // redirect to homepage if no profile available
        header("Location: index.php");
    }
} else {
    $username = $_GET["username"];
}
$user = new User($con, $username);

echo "WELL HELLO, " . $username;
?>

<?php require_once("includes/footer.php");?>