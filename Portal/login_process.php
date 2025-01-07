<?php
    require_once("../Class/userclass.php");
    

    session_start();

    if(isset($_POST["btnLogin"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
    
        $user = new User();
        $loginResult =  $user->Login($username, $password);

        var_dump($loginResult);

        if($loginResult['status']){
            $_SESSION['username'] = $username;
            $_SESSION['profile'] = $loginResult['profile'];
            $_SESSION['idmember'] = $loginResult['idmember'];
           
            if($loginResult['profile'] == "admin"){
                header("Location: ../home.php");
                exit();
            } else {
                header("Location: ../utama.php");
                exit();
            }
        }
    } else {
        header("Location: login.php");
        exit();
        
    }

    
?>