<?php 
require_once("includes/config.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/FormSanitizer.php");

$account = new Account($con);

if(isSet($_POST["submitButton"])) {

    $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]); //with static functions, we use the Class::function(vars) pattern
    $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);

    $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
    
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
    $emailConfirmation = FormSanitizer::sanitizeFormEmail($_POST["email2"]);
    
    $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
    $passwordConfirmation = FormSanitizer::sanitizeFormPassword($_POST["password2"]);

    if($password != $passwordConfirmation) {
        echo "Password confirmation does not match!";
        exit();
    } else if($email != $emailConfirmation) {
        echo "Email confirmation does not match!";
        exit();
    }

    $account->register($firstName, $lastName, $username, $email, $password);

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
            <h3>Sign Up</h3>
            <span>to continue to untuckTube</span>
        </div>
        <div class="signUpForm signInForm">
            <form action="signUp.php" method="POST">

                <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                <input type="text" name="firstName" placeholder="First name" autocomplete="off" required>
                <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                <input type="text" name="lastName" placeholder="Last name" autocomplete="off" required>
                <?php echo $account->getError(Constants::$usernameCharacters); ?>
                <input type="text" name="username" placeholder="Username" autocomplete="off" required>

                <input type="email" name="email" placeholder="Email" autocomplete="off" required>
                <input type="email" name="email2" placeholder="Confirm email" autocomplete="off" required>
                
                <input type="password" name="password" placeholder="Password" autocomplete="off" required>
                <input type="password" name="password2" placeholder="Confirm password" autocomplete="off" required>
                //TODO: email and password confirmations should match.
                <input type="submit" name="submitButton" value="SUBMIT">
            </form>

        </div>
        <a class="signInMessage" href="signIn.php">Already have an account? Sign in here!</a>
    </div>
</div>


</body>
</html>

<?php require_once("includes/footer.php");

/*
if(!isSet($_POST["submitButton"])) {
    echo "Signup form error!";
    exit();
}
*/


/*
// 2- Process video data
$videoProcessor = new VideoProcessor($con);
$wasSuccessful = $videoProcessor->upload($videoUploadData);


// 3- Check if upload was successful 
if ($wasSuccessful) {
    echo "Upload successful!";
}
*/


?>