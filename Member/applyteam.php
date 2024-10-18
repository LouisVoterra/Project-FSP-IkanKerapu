<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

require_once("../Class/userclass.php");
require_once("../Class/teamclass.php");

$sql = new Team();
$team = $sql->getAllTeams(); 

$object = new User();
$idmember = $object->idUser($username); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply Team</title>
</head>
<body>
    <form method="post" action="applyteam_process.php">
        <input type="text" name="idmember" value="<?php echo htmlspecialchars($idmember); ?>">
        
        <label for="team">Team:</label>
        <select name="name" id="team">
            <option value="">-- Pilih Team --</option>
            <?php foreach($team as $row) { ?>
                <option value="<?php echo $row['idteam']; ?>"><?php echo $row['name']; ?></option>
            <?php } ?>
        </select>

        <textarea id="description" name="description" placeholder="isi"></textarea>
        <button type="submit" name="submit">Daftar</button>
    </form>
</body>
</html>
