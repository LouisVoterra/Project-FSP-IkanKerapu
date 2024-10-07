<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idteam = $_POST['idteam'];
    $name = $_POST['name'];
    $date = date('Y-m-d', strtotime($_POST['date']));
    $description = $_POST['description'];

    $sql = "INSERT INTO achievement (idteam , name, date , description) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("isss",$idteam, $name, $date, $description);

    if ($stmt->execute()) {
        echo "Data berhasil ditambahkan.";
        echo "<br><a href='insertachievement.php'>Tambah event lagi</a>";
        echo "<br><a href='kelolaachievment.php'>Home</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Form belum disubmit.";
}
?>