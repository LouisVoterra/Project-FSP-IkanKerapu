<?php
require_once 'db.php';

if (isset($_GET['idteam']) && !empty($_GET['idteam'])) {
    $idteam = intval($_GET['idteam']); 

    $sql = "SELECT * FROM team WHERE idteam = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("i", $idteam);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $team = $result->fetch_assoc();

        $sql = "SELECT idgame, name FROM game";
        $games = $conn->query($sql);
    } else {
        echo "Team tidak ditemukan.";
        exit();
    }
} else {
    echo "ID team tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Team</title>
</head>
<body>

<h2>Edit Team</h2>

<form action="updateteam_proses.php" method="POST">
    <input type="hidden" name="idteam" value="<?php echo htmlspecialchars($team['idteam']); ?>">
    
    <label for="name">Nama Team:</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($team['name']); ?>" required>
    <br><br>
    
    <label for="idgame">Game:</label>
    <select id="idgame" name="idgame" required>
        <?php

        if ($games->num_rows > 0) {
            while ($row = $games->fetch_assoc()) {
                $selected = ($row["idgame"] == $team["idgame"]) ? "selected" : "";
                echo "<option value='" . $row["idgame"] . "' $selected>" . htmlspecialchars($row["name"]) . "</option>";
            }
        } else {
            echo "<option value=''>No games available</option>";
        }
        ?>
    </select>
    <br><br>
    
    <input type="submit" value="Update Team">
</form>

<a href="kelolateam.php">Kembali ke daftar team</a>

<?php

$conn->close();
?>

</body>
</html>