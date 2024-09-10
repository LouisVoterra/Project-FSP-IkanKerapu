<?php
include 'db.php';

$sql = "SELECT idteam, name FROM team";
$result = $conn->query($sql);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Achievement</title>
</head>
<body>

<h2>Tambah Data Achievement</h2>

<form action="insertachievement_proses.php" method="POST">
    <label for="name">Nama Achievement:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="description">Tanggal Achievement:</label><br>
    <input type="date" id="date" name="date"><br><br>

    <label for="description">Deskripsi Achievement:</label><br>
    <textarea id="description" name="description" required></textarea><br><br>
    
    <label for="idteam">Choose Team :</label>
    <select id="idteam" name="idteam" required>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["idteam"] . "'>" . htmlspecialchars($row["name"]) . "</option>";
            }
        } else {
            echo "<option value=''>No teams available</option>";
        }
        ?>
    </select>
    <br><br>

    <input type="submit" value="Submit">
</form>

</body>
</html>