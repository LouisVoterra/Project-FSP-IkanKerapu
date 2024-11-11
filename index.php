    <?php
    session_start();


    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    $username = $_SESSION['username'];
    $profile = $_SESSION['profile'];
    $status = $_SESSION['proposal_status'];
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Selamat Datang di Halaman Esport!</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="position">
            <nav class="navigation">
                <ul>
                    <li><a href="Member/applyteam.php">Apply Team</a></li>
                    <li><a href="Team/displayteam.php">Lihat Team</a></li>
                    <li><a href="Portal/logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
        <p>Nama: <?php echo htmlspecialchars($username); ?></p>
        <p>Profile: <?php echo htmlspecialchars($profile); ?></p>
        <h1 class="portal">Selamat datang di Club Informatics   !</h1>
        
    </body>
    </html>
