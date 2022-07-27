<?php
session_start();
 if (isset($_GET['logout'])) {
    $session = $_SESSION['username'];
    if ($session) {
        session_destroy();
        unset($session);
        header('location: ../forms/login.html');  
    }else {
        header('location: ../dashboard.php'); 
    }
}
?>