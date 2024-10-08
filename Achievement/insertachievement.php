<?php
require_once("../Class/teamclass.php");

// Assuming getAllTeams() retrieves all teams
$sql = new Team();
$result = $sql->getAllTeams(); // Fetch all teams without passing an argument

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

    <label for="date">Tanggal Achievement:</label><br>
    <input type="date" id="date" name="date" required><br><br> <!-- Added 'required' -->

    <label for="description">Deskripsi Achievement:</label><br>
    <textarea id="description" name="description" required></textarea><br><br>
    
    <label for="idteam">Choose Team :</label><br>
    <select id="idteam" name="idteam" required> <!-- Changed to a single select dropdown -->
        <option value="">Select a team</option> <!-- Placeholder option -->
        <?php 
        if ($result && count($result) > 0) {
            foreach($result as $teams) {
                echo "<option value='".htmlspecialchars($teams['idteam'])."'>".htmlspecialchars($teams['name'])."</option>";
            }
        } else {
            echo "<option value=''>Tidak ada tim tersedia</option>";
        }
        ?>
    </select>
    <br><br>

    <input type="submit" value="Submit">
</form>

</body>
</html>
