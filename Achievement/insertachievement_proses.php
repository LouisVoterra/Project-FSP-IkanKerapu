<?php
require_once("../Class/achievementclass.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idteam = $_POST['idteam'];
    $name = $_POST['name'];
    $date = date('Y-m-d', strtotime($_POST['date']));
    $description = $_POST['description'];

    $sql = new Achievement();
    $stmt = $sql->insertAchievement([
        'idteam' => $idteam,
        'name' => $name,
        'date' => $date,
        'description' => $description,

    ]);

    if ($stmt) {
        echo "<script>alert('Data inserted');</script>";
        header("Location: ../Kelola/kelolaachievment.php");
    } else {
        echo "<script>alert('Data not inserted');</script>";
        header("Location: insertachievement.php");
    }

   
} else {
    echo "Form belum disubmit.";
}
?>