<?php

require_once("../Class/userclass.php");

if (isset($_POST['btnSubmit'])) {
    if ($_POST['password'] == $_POST['repassword']) {
        $user = new User();
        $role = $user->Registrasi($_POST); 

        if ($role === 'member') {
            
            header("Location: ../index.php");
            exit();
        } elseif ($role === 'admin') {
            
            header("Location: ../home.php");
            exit();
        } else {
            
            header("Location: registration.php?error=failed");
            exit();
        }
    } else {
        
        header("Location: registration.php?error=password");
        exit();
    }
} else {
   
    header("Location: registration.php");
    exit();
}

