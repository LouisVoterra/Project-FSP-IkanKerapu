<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $idgame = $_POST['idgame'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    $sql = "UPDATE game SET name = ?, description = ? WHERE idgame = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ssi", $name, $description, $idgame);

    if ($stmt->execute()) {
        echo "Data berhasil diperbarui.";
        echo "<br><a href='kelolagame.php'>Kembali ke daftar game</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Data tidak dikirim.";
}
?>