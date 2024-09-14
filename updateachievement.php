<?php
include 'db.php';

if (isset($_GET['idachievement']) && !empty($_GET['idachievement'])) {
    $idachievement = intval($_GET['idachievement']); 

    $sql = "SELECT * FROM achievement WHERE idachievement = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("i", $idachievement);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $team = $result->fetch_assoc();

        $sql = "SELECT idteam, name FROM team";
        $games = $conn->query($sql);
    } else {
        echo "Team tidak ditemukan.";
        exit();
    }
} else {
    echo "ID achievement tidak ditemukan.";
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Achievement</title>
</head>
<body>

<h2>Edit Achievement</h2>

<form action="updateachievement_proses.php" method="POST">
    <input type="hidden" name="idachievement" value="<?php echo htmlspecialchars($team['idachievement']); ?>">
    
    <label for="name">Nama Achievement:</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($team['name']); ?>" required>
    <br><br>
    
    <label for="idgame">Team:</label>
    <select id="idteam" name="idteam" required>
        <?php

        if ($games->num_rows > 0) {
            while ($row = $games->fetch_assoc()) {
                $selected = ($row["idteam"] == $team["idteam"]) ? "selected" : "";
                echo "<option value='" . $row["idteam"] . "' $selected>" . htmlspecialchars($row["name"]) . "</option>";
            }
        } else {
            echo "<option value=''>No team available</option>";
        }
        ?>
    </select>
    <br><br>
    
    <input type="submit" value="Update Team">
</form>

<a href="home.php">Kembali ke Home</a>

<?php

$conn->close();
?>

</body>
</html>