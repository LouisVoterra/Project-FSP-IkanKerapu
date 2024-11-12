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

    if (isset($_FILES["poster"]) && $_FILES["poster"]["error"] == 0) {
        $target_dir = "../images/";
        $newPosterPath = $target_dir . $idteam . ".jpg";

        // Hanya izinkan file dengan ekstensi JPG
        $imageFileType = strtolower(pathinfo($_FILES["poster"]["name"], PATHINFO_EXTENSION));
        if ($imageFileType != "jpg") {
            echo "<script>alert('Hanya file JPG yang diizinkan.');</script>";
            header("Location: updateteam.php?idteam=$idteam");
            exit();
        }

        // Hapus gambar lama jika ada
        if (file_exists($newPosterPath)) {
            unlink($newPosterPath);
        }

        // Pindahkan file gambar baru
        if (move_uploaded_file($_FILES["poster"]["tmp_name"], $newPosterPath)) {
            echo "<script>alert('Data and image updated successfully');</script>";
            header("Location: ../Kelola/kelolateam.php");
        } else {
            echo "<script>alert('Data updated, but image upload failed');</script>";
            header("Location: updateteam.php?idteam=$idteam");
        }
    } elseif ($updateData) {
        echo "<script>alert('Data updated successfully');</script>";
        header("Location: ../Kelola/kelolateam.php");
    } else {
        echo "<script>alert('Data update failed');</script>";
        header("Location: updateteam.php?idteam=$idteam");
    }
}

?>
