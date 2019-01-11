<?php require_once("includes/header.php");

if(!isset($_GET["id"])) {
    echo "No url passed to the page!";
    exit();
}

/**** Get user data from db, create user object from username ****/
/*
$query = ("SELECT FROM users WHERE id=:userId");
$query->bindParam(":userId", $uid);
$query->execute();

$userRow = $query->fetch(PDO::FETCH_ASSOC);
$username = $userRow["username"];
*/
$username = $_GET["id"];
$user = new User($con, $username);


?>

<?php require_once("includes/footer.php");?>