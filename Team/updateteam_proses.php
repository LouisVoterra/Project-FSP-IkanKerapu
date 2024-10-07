<?php
require_once 'db.php';

$idteam = $_POST['idteam'];
$name = $_POST['name'];
$idgame = $_POST['idgame'];

$sql = "UPDATE team SET name = ?, idgame = ? WHERE idteam = ?";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("sii", $name, $idgame, $idteam);

if ($stmt->execute()) {
    echo "Team berhasil diperbarui.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: kelolateam.php");
exit();
?>