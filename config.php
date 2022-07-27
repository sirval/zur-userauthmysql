<?php
session_start();
    function db() {
        error_reporting(E_ALL);
        ini_set("log_errors", 1);
        ini_set("error_log", "/tmp/php-error.log");
        //set your configs here
        $host = "127.0.0.1";
        $user = "root";
        $db = "zuriphp";
        $password = "";
        $conn = mysqli_connect($host, $user, $password, $db);
        if(!$conn){
            echo "<script> alert('Error connecting to the database') </script>";
        }
        return $conn;
    }