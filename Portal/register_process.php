<?php

require_once("../Class/userclass.php");


if (isset($_POST['btnSubmit'])) {
    if ($_POST['password'] == $_POST['repassword']) {
        $user = new User();
        $role = $user->Registrasi($_POST); 
        header("Location: ../portal/login.php");
        
    } else {
        
        header("Location: registration.php?error=password");
        exit();
    }
} else {
   
    header("Location: registration.php");
    exit();
}