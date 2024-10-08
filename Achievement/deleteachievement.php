<?php
require_once("../Class/achievementclass.php");

if (isset($_GET['idachievement'])) {
    $idevent = intval($_GET['idachievement']); 
    $object = new Achievement();

    $arr_col = ['idachievement' => $idevent];

   
    if ($object->deleteAchievement($arr_col)) {
        
        header("Location: ../Kelola/kelolaachievment.php?status=success");
    } else {
        
        header("Location: ../Kelola/kelolaachivement.php?status=error");
    }
} else {
    echo "ID team tidak ditemukan.";
    exit();
}

exit();
?>