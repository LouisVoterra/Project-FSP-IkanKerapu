<?php
require_once 'db.php';

if (isset($_POST["submit"])) {

    $idachievement = intval($_POST['idachievement']);
    $name = $_POST['name'];
    $description = $_POST['description'];
    $idteam = intval($_POST['idteam']);

    $sql = "UPDATE achievement SET idteam = ?, name = ?, date = NOW(), description = ? WHERE idachievement = ?";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("issi", $idteam, $name, $description, $idachievement);

    if ($stmt->execute()) {
        echo "Achivement berhasil diperbarui.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();

    header("Location: kelolaachievment.php");
    exit();
}
?>