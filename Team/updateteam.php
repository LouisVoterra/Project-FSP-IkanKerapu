<?php
require_once("../Class/teamclass.php");
require_once("../Class/gameclass.php");

if(isset($_GET['idteam'])){
    $idteam = $_GET['idteam'];
    $object = new Team();
    $team = $object->getTeamById($idteam); 

    if(!$team){
        die("Team not found");
    }
} else {
    die("Team id is not provided");
}

$objectGame = new Game();
$games = $objectGame->getGame('');

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
            <div id="filediv">
                <div>
                    <input type="file" name="poster[]" id="poster"/>
                </div>
            </div>
    <br><br>
    
    <input type="submit" value="Update Team">
</form>

<a href="../Kelola/kelolateam.php">Kembali ke daftar team</a>

</body>
</html>
