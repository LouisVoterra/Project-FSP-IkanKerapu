<?php

require_once("../Class/teamclass.php");

if (isset($_POST['submit'])) {
    $name = $_POST['name']; 
    $idgame = $_POST['idgame'];

    // Pass the parameters as an array to insertTeam
    $team = new Team();
    $sql = $team->insertTeam([
        'idgame' => $idgame,
        'name' => $name,
    ]);

    if ($sql) {
        echo "<script>alert('Data inserted');</script>";
        header("Location: ../Kelola/kelolateam.php");
    } else {
        echo "<script>alert('Data not inserted');</script>";
        header("Location:  insertteam.php");
    }
}



?>