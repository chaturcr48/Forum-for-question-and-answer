<?php

$showAlert=false;
$showError="false";
if($_SERVER['REQUEST_METHOD']=='POST'){
    include "dbconnect.php";
    $username=$_POST['username'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $cpassword=$_POST['cpassword'];

    $existSql="SELECT * FROM `user` WHERE username='$username'";
    $result=mysqli_query($conn, $existSql);
    $numExistRows=mysqli_num_rows($result);
  
    if($numExistRows > 0){
        header("Location: /CHATUR_PHP/forum/home.php?userexist=true");
        exit();
    }
    else{
        if($password==$cpassword){
            $hash=password_hash("$password", PASSWORD_DEFAULT);
            $sql="INSERT INTO `user` (`username`, `email`, `password`) VALUES ('$username', '$email', '$hash');";
            $result=mysqli_query($conn, $sql);

            if($result){
                header("Location: /CHATUR_PHP/forum/home.php?signupsuccess=true");
                exit();
            }
        }
        else{
            header("Location: /CHATUR_PHP/forum/home.php?passunmatch=true");
            exit();
        }
    }
}

?>
