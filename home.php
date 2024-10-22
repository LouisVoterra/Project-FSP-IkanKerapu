<?php

session_start();


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$profile = $_SESSION['profile'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Halaman</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="position">
        <nav class="navigation">
            <ul>
                <li><a href="Kelola/kelolateam.php">Kelola Team</a></li>
                <li><a href="Kelola/kelolagame.php">Kelola Game</a></li>
                <li><a href="Kelola/kelolaachievment.php">Kelola Achievement</a></li>
                <li><a href="Kelola/kelolaevent.php">Kelola Event</a></li>
                <li><a href="Kelola/daftar_proposal.php">Daftar Proposal</a></li>
                <li><a href="Portal/logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
    <p>Nama: <?php echo htmlspecialchars($username); ?></p>
    <p>Profile: <?php echo htmlspecialchars($profile); ?></p>
    <h1 class="portal">Selamat datang di kelola Halaman Esport!</h1>
    
</body>
</html>
