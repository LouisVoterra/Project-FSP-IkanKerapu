<?php
require_once("../Class/teamclass.php");

if (isset($_GET['idteam'])) {
    $idteam = intval($_GET['idteam']); 
    $object = new Team();

    $arr_col = ['idteam' => $idteam];

    if ($object->deleteTeam($arr_col)) {

        header("Location: ../Kelola/kelolateam.php?status=success");
    } else {
        
        header("Location: ../Kelola/kelolateam.php?status=error");
    }
} else {
    echo "ID team tidak ditemukan.";
    exit();
}

exit();
?>
