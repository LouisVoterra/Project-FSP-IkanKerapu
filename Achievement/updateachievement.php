<?php

require_once("../Class/achievementclass.php");
require_once("../Class/teamclass.php"); 

if (isset($_GET['idachievement'])) {
    $idachievement = $_GET['idachievement'];
    

    
    $achievementObj = new Achievement();
    $teamObj = new Team();

    
    $achievement = $achievementObj->getAchievementById($idachievement); 
    if (!$achievement) {
        echo "Achievement not found.";
        exit();
    }

    
    $allTeams = $teamObj->getAllTeams();

   
    $relatedTeams = $achievementObj->getTeamsForAchievement($idachievement);
    $relatedTeamIds = array_column($relatedTeams, 'idteam'); 
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
    <input type="hidden" name="idachievement" value="<?php echo htmlspecialchars($achievement['idachievement']); ?>">
    
    <label for="name">Nama Achievement:</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($achievement['name']); ?>" required>
    <br><br>

    <label for="date">Tanggal Achievement:</label>
    <input type="date" name="date" value="<?php echo htmlspecialchars($achievement['date']); ?>" required>
    <br><br>
    
    <label for="description">Deskripsi Achievement:</label>
    <textarea id="description" name="description" required><?php echo htmlspecialchars($achievement['description']); ?></textarea>
    <br><br>
    
    <label for="idteam">Pilih Tim yang Terkait dengan Achievement Ini:</label><br>
    <?php 
    foreach($allTeams as $team) {
        $isChecked = in_array($team['idteam'], $relatedTeamIds) ? "checked" : "";
        echo "<input type='checkbox' name='idteam[]' value='".htmlspecialchars($team['idteam'])."' $isChecked> ".htmlspecialchars($team['name'])."<br>";
    }
    ?>
    <br><br>
    
    <input type="submit" value="Update Achievement" name="submit">
</form>

<a href="home.php">Kembali ke Home</a>

</body>
</html>
