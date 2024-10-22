<?php
require_once("../Class/achievementclass.php");

if (isset($_POST["submit"])) {
    $idachievement = intval($_POST['idachievement']); 
    $name = $_POST['name'];
    $date = date('Y-m-d', strtotime($_POST['date']));
    $description = $_POST['description'];
    $idteam = intval($_POST['idteam']);

    $sql = new Achievement();
    
    $updateData = [
        'idachievement' => $idachievement, 
        'name' => $name,
        'date' => $date,
        'description' => $description,
        'idteam' => $idteam,
    ];
    
    $stmt = $sql->updateAchievement($updateData); 

    if ($stmt) {
        header("Location: ../Kelola/kelolaachievment.php");
        exit();
    } else {
        echo "<script>alert('Update failed');</script>";
        header("Location: updateachievement.php");
        exit();
    }
}
?>
