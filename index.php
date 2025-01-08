<?php
require_once("Class/gameclass.php");

$game = new Game();
$result = $game->getGame('');
?> 



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kerapu Esport</title>
    <link rel="stylesheet" href="style.css">
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
                <li><a href="Portal/login.php">Login</a></li>
                <li>
                    <form id="game-form" action="Team/daftar_team.php" method="GET">
                        <select name="idgame" id="game-dropdown" onchange="submitForm()">
                            <option value="" disabled selected>-- Pilih Game --</option>
                            <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['idgame'] . '">' . htmlspecialchars($row['name']) . '</option>';
                                    }
                                } else {
                                    echo '<option value="">Tidak ada game tersedia</option>';
                                }          
                            ?> 
                        </select>
                    </form>
                </li>
                <li><a href="about.php">Tentang</a></li>
                <li><a href="index.php">Utama</a></li>
            </ul>
        </nav>
        <p class="portal">Selamat Datang di Halaman Esport!</p>
    </div>  
</body>
</html>
