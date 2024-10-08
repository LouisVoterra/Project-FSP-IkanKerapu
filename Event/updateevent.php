<?php
require_once("../Class/eventclass.php");
require_once("../Class/teamclass.php");


if (isset($_GET['idevent'])) {
    $idevent = $_GET['idevent'];

    $obj = new Event();
    $event = $obj->getEventbyId($idevent);
    if(!$event){
        die("Team not found");
    }
} else {
    echo "ID event tidak ditemukan.";
}
$sql = new Team();
$team = $sql->getAllTeams();
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Event</title>
    </head>
    <body>
        <h2>Update Data Event</h2>
        <form action="updateevent_proses.php" method="POST">
            <input type="hidden" name="idevent" value="<?php echo $event['idevent']; ?>">

            <label for="name">Nama Event:</label><br>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($event['name']); ?>" required><br><br>

            <label for="name">Tanggal Evemt:</label><br>
            <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($event['date']); ?>" required><br><br>

            <label for="description">Deskripsi Event:</label><br>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($event['description']); ?></textarea><br><br>

            <select id="idteam" name="team[]" required> <!-- Changed to a single select dropdown -->
            <option value="">Select a team</option> <!-- Placeholder option -->
            <?php 
            if ($team && count($team) > 0) {
                foreach($team as $teams) {
                    echo "<option value='".htmlspecialchars($teams['idteam'])."'>".htmlspecialchars($teams['name'])."</option>";
                }
            } else {
                echo "<option value=''>Tidak ada tim tersedia</option>";
            }
            ?>
            </select>
            <br><br>

            

            <input type="submit" value="Update">
        </form>
    </body>
</html>