<?php
    require_once("../Class/userclass.php");

    if(isset($_POST["btnLogin"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        // echo $username."<br><br>";
        // echo $password;
        $user = new User();
        if( $test = $user->Login($username, $password)) {
            if($test['profile']=="admin"){
                header("Location: ../home.php"); 
                exit();   
            }
            else{
                header("Location: ../index.php"); 
                exit(); 
            }
            
        } else {
            header("Location: login.php?error=loginfailed");
            exit();
        }
    } else {
        header("Location: login.php");
        exit();
        
    }

    
?>