<?php
require_once("../Class/teamclass.php");

$sql = new Team();
$result = $sql->getAllTeams(); 

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
    <input type="date" id="date" name="date" required><br><br> 

    <label for="description">Deskripsi Achievement:</label><br>
    <textarea id="description" name="description" required></textarea><br><br>
    
    <label for="idteam">Choose Team :</label><br>
    <select id="idteam" name="idteam" required> 
        <option value="">Select a team</option> 
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
