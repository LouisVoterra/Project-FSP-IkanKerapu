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
    <link rel="stylesheet" href="../style.css">
    <body>
    <div class="position">
        <nav class="navigation">
            <ul>
                <li><a href="kelolateam.php">Kelola Team</a></li>
                <li><a href="kelolagame.php">Kelola Game</a></li>
                <li><a href="kelolaachievment.php">Kelola Achievement</a></li>
                <li><a href="kelolaevent.php">Kelola Event</a></li>
                <li><a href="daftar_proposal.php">Daftar Proposal</a></li>
                <li><a href="../Portal/logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</head>
<body>

<h2>Edit Team</h2>

<form action="updateteam_proses.php" method="POST" enctype="multipart/form-data">
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

    <label for="poster">Gambar Team (Saat ini):</label><br>
    <?php
    $currentPoster = "../images/" . $team['idteam'] . ".jpg";
    if (file_exists($currentPoster)) {
        echo "<img src='$currentPoster' width='100' alt='Current Poster'><br><br>";
    } else {
        echo "No current image.<br><br>";
    }
    ?>

    <label for="poster">Upload Gambar Baru:</label>
    <input type="file" name="poster" id="poster">
    <small>Hanya file JPG yang diizinkan.</small>
    <br><br>
    
    <input type="submit" value="Update Team">
</form>

<a href="../Kelola/kelolateam.php">Kembali ke daftar team</a>

</body>
</html>
