<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $date = date('Y-m-d', strtotime($_POST['date']));
    $description = $_POST['description'];

    $sql = "INSERT INTO event (name, date , description) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("sss", $name, $date, $description);

    if ($stmt->execute()) {
        echo "Data berhasil ditambahkan.";
        echo "<br><a href='insertevent.php'>Tambah event lagi</a>";
        echo "<br><a href='home.php'>Home</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Form belum disubmit.";
}
?>