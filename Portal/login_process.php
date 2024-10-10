<?php
    require_once("../Class/userclass.php");

    // Start session
session_start();

if (isset($_POST["btnLogin"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $user = new User();
    $loginResult = $user->Login($username, $password);

    if ($loginResult['status']) {
        // Set session data
        $_SESSION['username'] = $username;
        $_SESSION['profile'] = $loginResult['profile'];

        // Redirect based on profile
        if ($loginResult['profile'] == "admin") {
            header("Location: ../home.php");
        } else {
            header("Location: ../index.php");
        }
        exit();
    } else {
        header("Location: login.php?error=loginfailed");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}

    

    
?>