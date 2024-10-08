<?php
require_once("../Class/achievementclass.php");
require_once("../Class/teamclass.php");

if (isset($_GET['idachievement'])) {
    $idachievement = $_GET['idachievement'];

    $sql = new Achievement();
    $stmt = $sql->getAchievementById($idachievement); // Pass the ID, not the whole object

    if (!$stmt) {
        echo "Achievement not found.";
        exit();
    }
} else {
    echo "ID achievement tidak ditemukan.";
    exit();
}

$sqlTeam = new Team();
$stmtTeam = $sqlTeam->getAllTeams(''); // Fetch all teams
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
    <input type="hidden" name="idachievement" value="<?php echo htmlspecialchars($stmt['idachievement']); ?>">
    
    <label for="name">Nama Achievement:</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($stmt['name']); ?>" required>
    <br><br>

    <label for="date">Tanggal Achievement:</label>
    <input type="date" name="date" value="<?php echo htmlspecialchars($stmt['date']); ?>" required>
    <br><br>
    
    <label for="description">Deskripsi Achievement:</label>
    <textarea id="description" name="description" required><?php echo htmlspecialchars($stmt['description']); ?></textarea>
    <br><br>
    
    <label for="idteam">Choose Team :</label><br>
    <select id="idteam" name="idteam" required> <!-- Changed to a single select dropdown -->
        <option value="">Select a team</option> <!-- Placeholder option -->
        <?php 
        if ($stmtTeam && count($stmtTeam) > 0) {
            foreach($stmtTeam as $teams) {
                echo "<option value='".htmlspecialchars($teams['idteam'])."'>".htmlspecialchars($teams['name'])."</option>";
            }
        } else {
            echo "<option value=''>Tidak ada tim tersedia</option>";
        }
        ?>
    </select>
    <br><br>
    
    <input type="submit" value="Update Achievement" name="submit">
</form>

<a href="home.php">Kembali ke Home</a>

</body>
</html>
