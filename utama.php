    <?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: portal/login.php");
        exit();
    }

    $username = $_SESSION['username'];
    $profile = $_SESSION['profile'];
    $idmember = $_SESSION['idmember'];
    
 
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
        <p>ID Member: <?php echo htmlspecialchars($idmember); ?></p>
        <h1 class="portal">Selamat datang di Club Informatics <?php echo htmlspecialchars($username); ?>   !</h1>
        
    </body>
    </html>
