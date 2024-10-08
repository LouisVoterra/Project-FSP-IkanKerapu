<?php

    require_once("../Class/userclass.php");


    if(isset($_POST['btnSubmit'])){

        if($_POST['password'] == $_POST['repassword']){
            $user = new User();
            $user->Registrasi($_POST);
            header("Location: ../home.php");
            exit();

        }
        else{
            header("Location: registration.php?error=password");
            exit();
        }

    }else{
        header("Location: registration.php");
        exit();
    }

?>