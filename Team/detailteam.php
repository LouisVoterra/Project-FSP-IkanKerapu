<?php
    require_once("../class/teamclass.php");
    require_once("../Class/gameclass.php");

    $game = new Game();
    $result = $game->getGame('');

    if (isset($_GET['idteam'])) {
        $idteam = intval($_GET['idteam']);
    } else {
        die("ID tim tidak ditemukan.");
    }

    $teamObj = new Team();

    $team = $teamObj->displayTeam_Member($idteam);
    if (!$team) {
        die("Tim tidak ditemukan.");
    }

    $events = $teamObj->displayEvent_Team($idteam);
    
    $achievements = $teamObj->displayAchievement_Team($idteam);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tim</title>
    <link rel="stylesheet" href="../style.css">
    <script>
        function submitForm() {
            document.getElementById("game-form").submit();
        }
    </script>
    
</head>
<body>
    <!-- Navbar -->
    <div class="position">
        <nav class="navigation">
            <ul>
            <li><a href="../Portal/login.php">Login</a></li>
                <li>
                    <form id="game-form" action="../Team/daftar_team.php" method="GET">
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
                <li><a href="../about.php">Tentang</a></li>
                <li><a href="../utama.php">Utama</a></li>
            </ul>
            </ul>
        </nav>
    </div>
    
   <br><br>


    <!-- Daftar Member Berdasarkan Game yang Dipilih -->
    <h2>Nama Team :</h2>
    <?php if (!empty($team)): ?>
        <table>
            <thead>
                <tr>
                    <th>Nama Member</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($team as $member): ?>
                    <tr>
                        <td><?php echo $member['nama']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif (isset($game_selected)): ?>
        <p>Belum ada member yang terdaftar untuk game "<?php echo $game_selected; ?>".</p>
    <?php endif; ?>

    <!-- Daftar Event -->
    <h2>Event yang Diikuti:</h2>
    <?php if (!empty($events)): ?>
        <table>
            <thead>
                <tr>
                    <th>Nama Event</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?php echo $event['name']; ?></td>
                        <td><?php echo $event['date']; ?></td>
                        <td><?php echo $event['description']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tim ini belum mengikuti event apapun.</p>
    <?php endif; ?>

    <!-- Daftar Pencapaian -->
    <h2>Pencapaian Tim:</h2>
    <?php if (!empty($achievements)): ?>
        <table>
            <thead>
                <tr>
                    <th>Nama Pencapaian</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($achievements as $achievement): ?>
                    <tr>
                        <td><?php echo $achievement['name']; ?></td>
                        <td><?php echo $achievement['date']; ?></td>
                        <td><?php echo $achievement['description']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tim ini belum memiliki pencapaian.</p>
    <?php endif; ?>

</body>
</html>
