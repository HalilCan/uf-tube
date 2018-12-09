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


        $this->firstName = $fn;
        $this->lastName = $ln;
        $this->username = $un;
        $this->email = $em;
        $this->password = $pw;
    }

    private function validateFirstName($fn) {
        if(strlen($fn) > 25 || strlen($fn) < 2) {
            array_push($this->errorArray, Constants::firstNameCharacters)
        }
    }

    private function validateLastName($fn) {

    }

    private function validateUsername($fn) {

    }

    private function validateEmail($fn) {

    }

    private function validatePassword($fn) {

    }

    public function getError($error) {
        if (in_array($error, $this->errorArray)) {
            return "<span class='error-message'>$error</span>"; //double quotes are what enables $var usage in the string.
        }
    }

}
?>