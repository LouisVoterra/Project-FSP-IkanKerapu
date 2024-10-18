<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}   


require_once("../Class/userclass.php");

if(isset($_POST['submit'])){
    $description = $_POST['description'];
    $idteam = $_POST['name'];
    $idmember = $_POST['idmember'];


    $proposal = new User();
    $sql = $proposal->join_proposal([
        'idteam' => $idteam,
        'idmember' => $idmember,
        'description' => $description,

    ]);

    if ($sql) {
        echo "<script>alert('Data inserted');</script>";
        header("Location: ../index.php");
    } else {
        echo "<script>alert('Data not inserted');</script>";
        header("Location:  insertteam.php");
    }
}

?>