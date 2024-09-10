<?php
include 'db.php';

if (isset($_GET['idevent']) && !empty($_GET['idevent'])) {
    $idteam = intval($_GET['idevent']); 

    $sql = "DELETE FROM event WHERE idevent = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("i", $idteam);

    if ($stmt->execute()) {
        echo "Evemt berhasil dihapus.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ID Event tidak ditemukan.";
}

$conn->close();

header("Location: home.php");
exit();
?>