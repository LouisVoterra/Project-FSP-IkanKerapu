<?php
require_once("../Class/teamclass.php");
session_start();

$team = new Team();
$teams = $team->getAllTeams(); // Ambil semua tim

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Team</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .card h3 {
            margin: 10px 0;
        }
        .card p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
        .card a {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 15px;
            color: white;
            background-color: #007BFF;
            border-radius: 5px;
            text-decoration: none;
        }
        .card a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="position">
        
        <nav class="navigation">
            <ul>
                <li><a href="../Team/daftarteam.php">Daftar Team</a></li>
                <li><a href="../Member/applyteam.php">Apply Team</a></li>
                <li><a href="../Team/displayteam.php">Lihat Team</a></li>
                <li><a href="../Portal/logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
    
    <h1 style="text-align: center;">Daftar Tim</h1>

    <div class="card-container">
    <?php if (!empty($teams)): ?>
        <?php foreach ($teams as $team): ?>
            <?php
                $namaposter = "../images/" . $team["idteam"] . ".jpg";
                if (!file_exists($namaposter)) {
                    $namaposter = "../images/" . $team["idteam"] . ".png";
                    if (!file_exists($namaposter)) {
                        $namaposter = "../images/blank.jpg";
                    }
                }
            ?>
            <div class="card">
                <img src="<?= $namaposter ?>" alt="Team Image" width="100" height="100" style="border-radius: 50%; object-fit: cover; margin-bottom: 10px;">
                <h3><?= htmlspecialchars($team['name']) ?></h3>
                <a href="detailteam.php?idteam=<?= htmlspecialchars($team['idteam']) ?>">Detail Tim</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align: center;">Tidak ada tim yang tersedia.</p>
    <?php endif; ?>
</div>
</body>
</html>
