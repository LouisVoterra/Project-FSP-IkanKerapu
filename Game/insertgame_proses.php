<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];

    $sql = "INSERT INTO game (name, description) VALUES (?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ss", $name, $description);

    if ($stmt->execute()) {
        echo "Data berhasil ditambahkan.";
        echo "<br><a href='insertgame.php'>Tambah game lagi</a>";
        echo "<br><a href='kelolagame.php'>daftar game</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Form belum disubmit.";
}
?>