<?php 
require_once("includes/config.php"); 
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/FormSanitizer.php");

$account = new Account($con);

function getInputValue($name) {
    if(isset($_POST[$name])) {
        echo $_POST[$name]; //using this allows for autofill on resubmission
    }
}

if(isSet($_POST["submitButton"])) {
    $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
    $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);

    $loginSuccessful = $account->login($username, $password);

    if($loginSuccessful) {
        $_SESSION["userLoggedIn"] = $username;
        header("Location: index.php");
    }
}  

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


</head>
<body>

<div class="signInContainer">
    <div class="column">
        <div class="header">
            <img id="siteLogo" src="assets/images/icons/unfuckTubeLogo.png">
            <h3>Sign In</h3>
            <span>to continue to unluckTube</span>
        </div>
        <div class="signUpForm signInForm">
            <form action="signIn.php" method="POST">
                <input type="text" name="username" placeholder="Username" value="<?php getInputValue('username'); ?>" required autocomplete="off">
                <input type="password" name="password" placeholder="Password" required autocomplete="off">
                <?php echo $account->getError(Constants::$loginFailed); ?>
                <input type="submit" name="submitButton" value="SUBMIT">
            </form>
            
        </div>
        <a class="signInMessage" href="signUp.php">Don't have an account? Sign up here!</a>
    </div>
</div>


</body>
</html>