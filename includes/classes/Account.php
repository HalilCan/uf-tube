<?php 
class Account {
    
    private $con;
    private $firstName, $lastName, $username, $email, $password;

    public function __construct($con){
        $this->con = $con;
    }

    public function register($fn, $ln, $un, $em, $pw) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;

    }

}
?>