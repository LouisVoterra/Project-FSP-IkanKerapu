<?php
require_once 'db.php';

if (isset($_GET['idteam']) && !empty($_GET['idteam'])) {
    $idteam = intval($_GET['idteam']); 

    $sql = "DELETE FROM team WHERE idteam = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("i", $idteam);

    if ($stmt->execute()) {
        echo "Team berhasil dihapus.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ID team tidak ditemukan.";
}

$conn->close();

header("Location: kelolateam.php");
exit();
?>