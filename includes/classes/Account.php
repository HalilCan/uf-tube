<?php 
class Account {
    
    private $con;
    private $errorArray = array();
    
    private $firstName, $lastName, $username, $email, $password;


    public function __construct($con){
        $this->con = $con;
    }

    public function register($fn, $ln, $un, $em, $em2, $pw, $pw2) {
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateUsername($un);
        $this->validateEmail($em, $em2);
        $this->validatePassword($pw, $pw2);

        if(empty($this->errorArray)) {
            return $this->insertUserDetails($fn, $ln, $un, $em, $pw);
        } else {
            return false;
        }
    }

    public function insertUserDetails($fn, $ln, $un, $em, $pw) {
        $query = $this->con->prepare("INSERT INTO users(firstName, lastName, username, email, password) '
                                        VALUES(:firstName, :lastName, :username, :email, :password)");
        
        $pw = hash("sha512", $pw);
        
        $query->bindParam(":firstName", $fn);
        $query->bindParam(":lastName", $ln);
        $query->bindParam(":username", $un);
        $query->bindParam(":email", $em);
        $query->bindParam(":password", $pw);

        return $query->execute();
    }


    private function validateFirstName($fn) {
        if(strlen($fn) > 25 || strlen($fn) < 2) {
            array_push($this->errorArray, Constants::$firstNameCharacters);
        }
    }

    private function validateLastName($ln) {
        if(strlen($ln) > 25 || strlen($ln) < 2) {
            array_push($this->errorArray, Constants::$lastNameCharacters);
        }

    }

    private function validateUsername($un) {
        if(strlen($un) > 100 || strlen($un) < 2) {
            array_push($this->errorArray, Constants::$usernameCharacters);
            return;
        }

        $query = $this->con->prepare("SELECT username FROM users WHERE username=:un");
        $query->bindParam(":un", $un);
        $query->execute();

        if($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$usernameTaken);
        }
    }

    private function validateEmail($em, $em2) {
        if($em != $em2) {
            array_push($this->errorArray, Constants::$emailMismatch);
            return;
        }

        if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        $query = $this->con->prepare("SELECT email FROM users WHERE email=:em");
        $query->bindParam(":em", $em);
        $query->execute();

        if($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$emailInUse);
        }
    }

    private function validatePassword($pw, $pw2) {
        if($pw != $pw2) {
            array_push($this->errorArray, Constants::$passwordMismatch);
            return;
        }

        if(preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z])/", $pw)) {
            array_push($this->errorArray, Constants::$passwordWeak);
            return;
        }
        
        if(strlen($pw) > 100 || strlen($pw) < 8) {
            array_push($this->errorArray, Constants::$passwordLength);
            return;
        }
    }

    public function getError($error) {
        if (in_array($error, $this->errorArray)) {
            return "<span class='error-message'>$error</span>"; //double quotes are what enables $var usage in the string.
        }
    }

}
?>