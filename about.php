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
    <title>Selamat Datang di Halaman Esport!</title>
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
            </ul>
        </nav>
    </div>  
    <header>
        
        
    </header>

    <section class="portal" id="sejarah">
        <h2>Sejarah Kami</h2>
        <p>Ikan Kerapu Esport merupakan organisasi Esport yang sudah lama berdiri sejak tahun 2010.</p>
        <p>Didirikan oleh sekelompok gamer yang berdedikasi, Ikan Kerapu Esport berawal dari sebuah komunitas kecil di kota pesisir. Seiring waktu, organisasi ini berkembang menjadi salah satu tim Esport paling kompetitif di tanah air.</p>
    </section>

    


</body>
</html>
