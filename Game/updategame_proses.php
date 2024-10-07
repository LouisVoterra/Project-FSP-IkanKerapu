<?php
require_once '../Database/db.php';  // Ensure this path is correct
require_once '../Class/gameclass.php';  // Include your team class


if (isset($_POST['idgame'], $_POST['name'], $_POST['description'])) {
   
    $idgame = $_POST['idgame'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    $game = new Game();


    $result = $game->updateGame([
        'idgame' => $idgame,
        'name' => $name,
        'description' => $description
    ]);

    if ($result) {
        echo "<script>alert('Team berhasil diperbarui.');</script>";
    } else {
        echo "<script>alert('Error: Gagal memperbarui tim.');</script>";
    }

    header("Location: ../Kelola/kelolagame.php");
    exit();
} else {
    echo "Form data is incomplete.";
}

?>
