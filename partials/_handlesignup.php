<?php

$showerror="false";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    include 'dbconnect.php';
    $user_email = $_POST['signupEmail'];
    $pass = $_POST['signuppassword'];
    $cpass = $_POST['signupcpassword'];

    // Check whether this email exists

    $sql="SELECT * FROM `users` WHERE user_email = '$user_email'";
    $result= mysqli_query($conn,$sql);
    $numrows = mysqli_num_rows($result);
    if($numrows>0){

        $showerror = "Email already in use";
        header("location:/forum/index.php?signup=false&error=$showerror");

    }
    
    else{

        if($pass==$cpass){
          $hash = password_hash($pass,PASSWORD_DEFAULT);
          $sql = "INSERT INTO `users` (`user_email`, `user_pass`, `timestamp`) VALUES ('$user_email', '$hash', CURRENT_TIMESTAMP())";
          $result = mysqli_query($conn,$sql);
          if($result){
            $showalert = true;
            header("location:/forum/index.php?signupsuccess=true");
            exist();
        }
    }
    else{
        $showerror = "Password do not match";
        header("location:/forum/index.php?signup=false&error=$showerror");
        exist();

        }
    }
}
?>