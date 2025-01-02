<?php
require_once("../Class/teamclass.php");
require_once("../Class/gameclass.php");
session_start();

// Ambil idgame dari GET
$gameId = isset($_GET['idgame']) ? (int) $_GET['idgame'] : null;

$team = new Team();
$result = $team->getTeamsByGameId($gameId);

$game = new Game();
$resultgame = $game->getGame('');
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
    <script>
        function submitForm() {
            document.getElementById("game-form").submit();
        }
    </script>
</head>
<body>
<div class="position">
    <nav class="navigation">
        <ul>
            <li><a href="../Portal/login.php">Login</a></li>
            <li>
                <form id="game-form" action="daftar_team.php" method="GET">
                    <select name="idgame" id="game-dropdown" onchange="submitForm()" required>
                        <option value="" disabled <?= is_null($gameId) ? 'selected' : '' ?>>-- Pilih Game --</option>
                        <?php
                        if ($resultgame->num_rows > 0) {
                            while ($row = $resultgame->fetch_assoc()) {
                                $selected = ($row['idgame'] == $gameId) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($row['idgame']) . '" ' . $selected . '>' . htmlspecialchars($row['name']) . '</option>';
                            }
                        } else {
                            echo '<option value="">Tidak ada game tersedia</option>';
                        }
                        ?>
                    </select>
                </form>
            </li>
            <li><a href="../about.php">Tentang</a></li>
            <li><a href="../utama.php">Utama</a></li>
        </ul>
    </nav>
</div>

<h1 style="text-align: center;">Daftar Tim</h1>

<div class="card-container">
    <?php if (!empty($result)): ?>
        <?php foreach ($result as $team): ?>
            <?php
            // Cek keberadaan file gambar
            $imageExtensions = ['jpg', 'png'];
            $namaposter = "../images/blank.jpg"; // Default image
            foreach ($imageExtensions as $ext) {
                $filePath = "../images/" . $team["idteam"] . ".$ext";
                if (file_exists($filePath)) {
                    $namaposter = $filePath;
                    break;
                }
            }
            ?>
            <div class="card">
                <img src="<?= htmlspecialchars($namaposter) ?>" alt="Team Image" width="100" height="100" style="border-radius: 50%; object-fit: cover; margin-bottom: 10px;">
                <h3><?= htmlspecialchars($team['team_name']) ?></h3>
                <a href="detailteam.php?idteam=<?= htmlspecialchars($team['idteam']) ?>">Detail Tim</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align: center;">Tidak ada tim yang tersedia.</p>
    <?php endif; ?>
</div>
</body>
</html>
