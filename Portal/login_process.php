<?php
require_once("../Class/userclass.php");

session_start();

if(isset($_POST["btnLogin"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $user = new User();
    $loginUser = $user->LoginUser($username, $password);
    $loginAdmin = $user->LoginAdmin($username, $password);

    if (is_array($loginUser) && isset($loginUser['status']) && $loginUser['status']) {
        $_SESSION['username'] = $username;
        $_SESSION['profile'] = $loginUser['profile'];
        $_SESSION['proposal_status'] = $loginUser['proposal_status'];
        $_SESSION['id_member'] = $loginUser['id_member'];
        $_SESSION['id_team'] = $loginUser['id_team'];
        $_SESSION['nama'] = $loginUser['nama'];

        header("Location: ../index.php");
        exit();
    } 
    else if (is_array($loginAdmin) && isset($loginAdmin['profile']) && $loginAdmin['profile']) {
        $_SESSION['username'] = $username;
        $_SESSION['profile'] = $loginAdmin['profile'];
        header("Location: ../home.php");
        exit();
    } 
    else {
        // Tangani kegagalan login (redirect atau tampilkan pesan error)
        header("Location: login.php?error=invalid_credentials");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
