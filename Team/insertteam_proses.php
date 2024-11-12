<?php

require_once("../Class/teamclass.php");

if (isset($_POST['submit'])) {
    $name = $_POST['name']; 
    $idgame = $_POST['idgame'];
    $target_dir = "../images/";
    $imageFileType = strtolower(pathinfo($_FILES["poster"]["name"], PATHINFO_EXTENSION));

    if($imageFileType != "jpg"){
        echo "<script>alert('Only JPG files are allowed.');</script>";
        header("Location: insertteam.php");
        exit();
    }
    else{
        $team = new Team();
        $last_id = $team->insertTeam([
            'idgame' => $idgame,
            'name' => $name,
        ]);
        $newname = $target_dir . $last_id . "." . $imageFileType;
        if ($last_id) {
           
            // Pindahkan file poster ke lokasi baru dengan nama baru
            if (move_uploaded_file($_FILES["poster"]["tmp_name"], $newname)) {
                echo "<script>alert('Data and file inserted successfully');</script>";
                header("Location: ../Kelola/kelolateam.php");
            } else {
                echo "<script>alert('Data inserted, but file upload failed');</script>";
                header("Location: insertteam.php");
            }
        } else {
            echo "<script>alert('Data not inserted');</script>";
            header("Location: insertteam.php");
        }
    }
}
?>