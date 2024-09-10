<?php
include 'db.php';

$name = $_POST['name'];
$idgame = $_POST['idgame'];

$sql = "INSERT INTO team (name, idgame) VALUES (?, ?)";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("si", $name, $idgame);

if ($stmt->execute()) {
    echo "Team berhasil ditambahkan.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: home.php");
exit();
?>