    <?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    $username = $_SESSION['username'];
    $profile = $_SESSION['profile'];
    $status = $_SESSION['proposal_status'];
    $idmember = $_SESSION['id_member'];
    $idteam = $_SESSION['id_team'];
    $nama = $_SESSION['nama'];
 
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kerapu Esport</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="position">
            <nav class="navigation">
                <ul>
                    <li><a href="index.php">Halaman Utama</a></li>
                    <li><a href="Member/applyteam.php">Apply Team</a></li>
                    <li><a href="Team/displayteam.php">Lihat Team</a></li>
                    <li><a href="Portal/logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
        <p>username: <?php echo htmlspecialchars($username); ?></p>
        <p>Nama: <?php echo htmlspecialchars($nama); ?></p>
        <p>ID Member: <?php echo htmlspecialchars($idmember); ?></p>
        <p>ID Team: <?php echo htmlspecialchars($idteam); ?></p>
        <h1 class="portal">Selamat datang di Club Informatics <?php echo htmlspecialchars($username); ?>   !</h1>
        
    </body>
    </html>
