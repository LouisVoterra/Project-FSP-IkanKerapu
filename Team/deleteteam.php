<?php
require_once("../Class/teamclass.php");

if (isset($_GET['idteam'])) {
    $idteam = intval($_GET['idteam']); 
    $object = new Team();

    // Create an associative array to pass to deleteTeam
    $arr_col = ['idteam' => $idteam];

    // Call deleteTeam and check the result
    if ($object->deleteTeam($arr_col)) {
        // If deletion is successful, redirect
        header("Location: kelolateam.php?status=success");
    } else {
        // If deletion failed, you can set a status or error message
        header("Location: kelolateam.php?status=error");
    }
} else {
    echo "ID team tidak ditemukan.";
    exit();
}

// If you manage the connection outside the class, uncomment this
// $conn->close();
exit();
?>
