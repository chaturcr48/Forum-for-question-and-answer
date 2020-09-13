<?php

if($_SERVER['REQUEST_METHOD']=="POST"){
    include "dbconnect.php";
    $username=$_POST['username'];
    $email=$_POST['email'];
    $password=$_POST['password'];

    $sql="SELECT * FROM `user` where username='$username'";
    $result=mysqli_query($conn, $sql);
    $num=mysqli_num_rows($result);
    if($num==1){
        $row=mysqli_fetch_assoc($result);
        if(password_verify($password, $row['password'])){
          session_start();
          $_SESSION['loggedin']=true;
          $_SESSION['username']=$username;
          $_SESSION['sno']=$row['sno'];
          $username=$_SESSION['username'];

          header("location: /CHATUR_PHP/forum/home.php?loginsuccess=true");
          exit();
        }
        else{
          header("location: /CHATUR_PHP/forum/home.php?incorrectpass=true");
          exit();
        }
    }
    else{
      header("location: /CHATUR_PHP/forum/home.php?notsignedup=true");
      exit();
    }
}

?>