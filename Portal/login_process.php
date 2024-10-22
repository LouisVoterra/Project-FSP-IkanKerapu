<?php
    require_once("../Class/userclass.php");
    

    session_start();

    if(isset($_POST["btnLogin"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
    
        $user = new User();
        $loginResult =  $user->login($username, $password);

        if($loginResult['status']){
            $_SESSION['username'] = $username;
            $_SESSION['profile'] = $loginResult['profile'];
            if($loginResult['profile'] == "admin"){
                header("Location: ../home.php");
                exit();
            } else {
                header("Location: ../index.php");
                exit();
            }
        }
    } else {
        header("Location: login.php");
        exit();
        
    }

    
?>