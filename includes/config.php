<?php
    ob_start(); //turns on output buffering
    session_start();

    date_default_timezone_set("America/New_York");

    try {
        $con = new PDO("mysql:dbname=uftube;host=localhost", "root", ""); //config, admin login, pw
        $con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //sets the first attribute to the second value
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

?>