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
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="position">
            <nav class="navigation">
                <ul>
                    <li><a href="../index.php">Halaman Utama</a></li>
                    <li><a href="../Member/applyteam.php">Apply Team</a></li>
                    <li><a href="../Team/displayteam.php">Lihat Team</a></li>
                    <li><a href="../Portal/logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    <form method="post" action="applyteam_process.php">
        <input type="hidden" name="idmember" value="<?php echo htmlspecialchars($idmember); ?>">
        <h1>Form Aplikasi </h1>
        <label for="team">Team:</label><br>
        <select name="name" id="team">
            <option value="">-- Pilih Team --</option>
            <?php foreach($team as $row) { ?>
                <option value="<?php echo $row['idteam']; ?>"><?php echo $row['name']; ?></option>
            <?php } ?>
        </select><br><br>

        <textarea id="description" name="description" placeholder="isi"></textarea><br><br>
        <button type="submit" name="submit">Daftar</button>
    </form>
</body>
</html>
