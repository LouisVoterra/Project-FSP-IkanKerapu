<?php
require_once '../Database/db.php';  
require_once '../Class/teamclass.php';  


if (isset($_POST['idteam'], $_POST['name'], $_POST['idgame'])) {
   
    $idteam = $_POST['idteam'];
    $name = $_POST['name'];
    $idgame = $_POST['idgame'];

    $team = new Team();

    $updateData = [
        'idteam' => $idteam,
        'name' => $name,
        'idgame' => $idgame
    ];

    $result = $team->updateTeam($updateData);

    if ($result) {
        echo "<script>alert('Team berhasil diperbarui.');</script>";
    } else {
        echo "<script>alert('Error: Gagal memperbarui tim.');</script>";
    }

    header("Location: ../Kelola/kelolateam.php");
    exit();
} else {
    echo "Form data is incomplete.";
}

?>
