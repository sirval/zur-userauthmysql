
<?php

require_once "../config.php";
//check if user exists

function findEmail($email)
{
    $conn = db();
    $find_user = $conn->query("SELECT `email` FROM `students` WHERE `email` = '$email'");
    return $find_user;
    
}
//check user password
function findPassword($password)
{
    $conn = db();
    $find_user_password = $conn->query("SELECT `password` FROM `students` WHERE `password` = '$password'");
    return $find_user_password;
}
//register users
function registerUser($fullnames, $email, $password, $gender, $country){
    //create a connection variable using the db function in config.php
    $conn = db();
   //check if user with this email already exist in the database
   $get_email = findEmail($email);
   if ($get_email->num_rows <= 0) {
        $register_user = $conn->query("INSERT INTO `students`(`full_names`, `country`, `email`, `gender`, `password`) VALUES ('$fullnames','$country','$email','$gender','$password')");
        if ($register_user ) {
                echo "success";
        }else {
                echo "error";
        }
    }else {
        echo "email_error";
    }
}


//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    $get_email = findEmail($email); 
    $get_password = findPassword($password);
        $login_user = $conn->query("SELECT `id`, `full_names` FROM `students` WHERE `email` = '$email' && `password` = '$password'");
    if ($get_email->num_rows == 1 && $get_password->num_rows == 1) {
        while ($result = $login_user->fetch_array()) {
                $username = $result['full_names'];
                $id = $result['id'];
        }
        //create session variables
        $_SESSION['username'] = $username;
        echo "success";
    }else {
        echo "error";
    }
}
//reset user password
function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    $get_email = findEmail($email);
    if ($get_email->num_rows == 1) {
        $reset_password = $conn->query("UPDATE `students` SET `password`='$password' WHERE `email` = '$email'");
        if ($reset_password  === true) {
            echo "success";
        }else {
            echo "error";
        }
    }
}

function getusers(){
    
  
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    if(!isset($_SESSION['username'])){  header("location: ../forms/login.html"); }
   else{
        echo"<html>
        <head>
        <script src='../assets/js/jquery.min.js' ></script>
        <script src='../assets/js/sweetalert2.all.min.js'></script>
        </head>
        <body>
        <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
        <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
        <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
        if(mysqli_num_rows($result) > 0){
            while($data = mysqli_fetch_assoc($result)){
                //show data
                echo "<tr style='height: 30px'>".
                    "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                    <td style='width: 150px'>" . $data['full_names'] .
                    "</td> <td style='width: 150px'>" . $data['email'] .
                    "</td> <td style='width: 150px'>" . $data['gender'] . 
                    "</td> <td style='width: 150px'>" . $data['country'] . 
                    "</td>
                    <form action='action.php' method='post'>
                    <input type='hidden' name='id'" .
                    "value=" . $data['id'] . ">".
                    "<td style='width: 150px'> <button type='submit' name='delete'> DELETE </button>".
                    "</tr>";
            }
            echo "</table></table></center>
            <div class='container'>
                <div class='center'>
                    <a href='../dashboard.php' class='btn btn-danger btn-sm'>Dashboard</a>
                </div>
            </div>
            </body></html>";
        }
        if (isset($_GET['success'] )) {
            echo '<script type="text/javascript">
            setTimeout(function () { Swal.fire("Success!","User Deleted Successfully!","success");
            }, 1000);</script>';
        }
        if (isset($_GET['error']) ) {
            echo '<script type="text/javascript">
            setTimeout(function () { Swal.fire("Error!","Failed!","error");
            }, 1000);</script>';
        }
    }
    //return users from the database
    //loop through the users and display them on a table
}

 function deleteaccount($id){
     $conn = db();
     //delete user with the given id from the database
     $delete_user = $conn->query("DELETE FROM `students` WHERE `id` = '$id'");
     if ($delete_user === true) {
        header("location: ./action.php?success");
     }else {
        header("location: ./action.php?error");
     }
 }