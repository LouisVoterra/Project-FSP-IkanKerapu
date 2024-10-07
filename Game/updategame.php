<?php
require_once("../Class/gameclass.php");

if(isset($_GET['idgame'])){
    $idgame = $_GET['idgame'];
    $object = new Game();
    $game = $object->getGameById($idgame);

    if(!$game){
        die("Team not found");
    }
} else {
    die("Team id is not provided");
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

<h2>Edit Game</h2>

<form action="updategame_proses.php" method="POST">
    <input type="hidden" name="idgame" value="<?php echo htmlspecialchars($game['idgame']); ?>">
    
    <label for="name">Nama Game:</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($game['name']); ?>" required>
    <br><br>

    <label for="description">Deskripsi Game:</label><br>
    <textarea id="description" name="description" required><?php echo htmlspecialchars($game['description']); ?></textarea>
    <br><br>
    
    <input type="submit" value="Update Game">
</form>


<a href="../Kelola/kelolateam.php">Kembali ke daftar team</a>

</body>
</html>
