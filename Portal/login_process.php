<?php
    require_once("../Class/userclass.php");
    

    session_start();

    if(isset($_POST["btnLogin"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
    
        $user = new User();
        $loginUser =  $user->LoginUser($username, $password);
        $loginAdmin = $user->LoginAdmin($username, $password);

        if($loginUser['status']){
            $_SESSION['username'] = $username;
            $_SESSION['profile'] = $loginUser['profile'];
            $_SESSION['proposal_status'] = $loginUser['proposal_status'];
            header("Location: ../index.php");
            exit();
            // if($loginUser['profile'] == "admin"){
            //     header("Location: ../home.php");
            //     exit();
            // } else {
            //     header("Location: ../index.php");
            //     exit();
            // }
        }
        else if($loginAdmin['profile']){
            $_SESSION['username'] = $username;
            $_SESSION['profile'] = $loginAdmin['profile'];
            header("Location:../home.php");
            exit();

        }
    } else {
        header("Location: login.php");
        exit();
        
    }

    
?>