<?php
require_once("../Class/teamclass.php");
require_once("../Class/gameclass.php");


$team = new Game(); 
$result = $team->getGame(''); // Kosongkan keyword untuk mendapatkan semua data

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Team</title>
</head>
<body>

<h2>Tambah Team</h2>

<form action="insertteam_proses.php" method="POST">
    <label for="name">Nama Team:</label>
    <input type="text" id="name" name="name" required>
    <br><br>
    
    <label for="idgame">Game:</label>
    <select id="idgame" name="idgame" required>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["idgame"] . "'>" . htmlspecialchars($row["name"]) . "</option>";
            }
        } else {
            echo "<option value=''>No games available</option>";
        }
        ?>
    </select>
    <br><br>
    
    <input type="submit" value="Tambah Team" name="submit">
</form>

<a href="kelolateam.php">Kembali ke Daftar team</a>

<?php
// Tidak perlu $conn->close() karena koneksi ada di dalam class Team
?>

</body>
</html>
