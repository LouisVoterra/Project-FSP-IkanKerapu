<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idevent = $_POST['idachievement'];
    $name = $_POST['name'];
    $date = date('Y-m-d', strtotime($_POST['date']));
    $description = $_POST['description'];

    $sql = "UPDATE achievement SET name = ?,date = ?, description = ? WHERE idachievement = ?";

    $stmt = $conn->prepare($sql);

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("sssi",$name, $date , $description, $idevent);

    if ($stmt->execute()) {
        echo "Data berhasil diperbarui.";
        echo "<br><a href='home.php'>Kembali ke daftar event</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Data tidak terkirim.";
}
?>